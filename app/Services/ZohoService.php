<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ZohoService implements Contracts\ZohoServiceContract
{
    protected function getClientId(): string
    {
        return config('services.zoho.client_id');
    }

    protected function getClientSecret(): string
    {
        return config('services.zoho.client_secret');
    }

    protected function getRefreshToken(): string
    {
        return config('services.zoho.refresh_token');
    }

    public function apiUrl(?string $path, $isAuth = false): string
    {
        if ($isAuth) {
            $domain = config('services.zoho.accounts_domain');
        } else {
            $domain = session('zoho_api_domain') ?? config('services.zoho.api_domain');
        }

        return rtrim($domain, '/') . '/' . ltrim($path, '/');
    }

    protected function storeSessionData(array $data): void
    {
        session([
            'zoho_access_token' => $data['access_token'],
            'zoho_api_domain' => $data['api_domain'],
            'zoho_token_expires_at' => now()->addSeconds($data['expires_in']),
        ]);
    }

    protected function requestAccessToken(array $params): ?array
    {
        $response = Http::asForm()->post($this->apiUrl('oauth/v2/token', true), $params);

        return $response->successful() ? $response->json() : null;
    }

    public function refreshAccessToken(): bool
    {
        if (!$refreshToken = $this->getRefreshToken()) {
            return false;
        }

        $data = $this->requestAccessToken([
            'grant_type' => 'refresh_token',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $refreshToken,
        ]);

        if ($data) {
            $this->storeSessionData($data);
            return true;
        }

        return false;
    }

    public function createByModule(string $module, array $data): Response
    {
        return Http::withHeaders([
            'Authorization' => "Bearer " . session('zoho_access_token'),
        ])->post($this->apiUrl("crm/v2/{$module}"), [
            'data' => [$data],
        ]);
    }

    public function getDataByModule(string $module, string $fields): array|false
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . session('zoho_access_token'),
        ])->get($this->apiUrl("crm/v2/{$module}"), [
            'fields' => $fields,
        ]);

        return $response->successful() ? $response->json()['data'] : false;
    }

    public function isTokenExpired(): bool
    {
        return session()->missing('zoho_access_token') ||
            (session()->has('zoho_token_expires_at') &&
                now()->greaterThan(session('zoho_token_expires_at')));
    }
}
