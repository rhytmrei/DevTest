<?php

namespace App\Services\Contracts;

use Illuminate\Http\Client\Response;

interface ZohoServiceContract
{
    /**
     * Refresh the access token using the refresh token.
     *
     * @return bool
     */
    public function refreshAccessToken(): bool;

    /**
     * Create a new record in the specified module.
     *
     * @param string $module The module to create the record in.
     * @param array $data The data for the new record.
     * @return Response
     */
    public function createByModule(string $module, array $data): Response;

    /**
     * Get Data by module name from Zoho CRM.
     *
     * @param string $module
     * @param string $fields
     * @return array|false
     */
    public function getDataByModule(string $module, string $fields): array|false;

    /**
     * Check if the access token is expired.
     *
     * @return bool
     */
    public function isTokenExpired(): bool;

    /**
     * Get the API URL for a given path.
     *
     * @param string|null $path The path to append to the base URL.
     * @param bool $isAuth Whether the URL is for authentication.
     * @return string
     */
    public function apiUrl(?string $path, bool $isAuth = false): string;
}
