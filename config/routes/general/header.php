<?php
/**
 * @OA\Info(
 *   title="Sample MS API",
 *   version="1.0.0",
 *   description="All top-level API resources have support for bulk fetches via list API methods. For instance, you can
    list charges, list customers, and list invoices. These list API methods share a common structure, taking these
    follow parameters: equals, greaterThan, lessThan, greaterOrEqualThan, lessOrEqualThan, in, year, month, contains,
    sort.<br><br>Our client libraries offer auto-pagination to easily traverse all pages of a list.<br><br>
    <strong>Pagination</strong><br>You can paginate the list using page={number} to set a current page or use
    size={number} to show number of registers by page"
 * )
 */
/**
 * @OA\SecurityScheme(
 *   securityScheme="ApiKey",*   type="apiKey",
 *   in="header",
 *   name="X-API-KEY"
 * )
 */
/**
 * @OA\SecurityScheme(
 *   securityScheme="ApiClient",
 *   type="apiKey",
 *   in="header",
 *   name="X-API-CLIENT"
 * )
 */
/**
 * @OA\SecurityScheme(
 *   securityScheme="AppId",
 *   type="apiKey",
 *   in="header",
 *   name="X-APP-ID"
 * )
 */
/**
 * @OA\SecurityScheme(
 *   securityScheme="UserToken",
 *   type="apiKey",
 *   in="header",
 *   name="X-USER-TOKEN"
 * )
 */
