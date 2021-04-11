<?php
/**
 * @OA\Get(
 *   path="/api/u1/condid/{condid}/profile/{profile}/userid/{userid}",
 *   tags={"ping"},
 *   summary="get by ping sample",
 *   @OA\Response(
 *     response=200,
 *     description="An ping",
 *   ),
 *   @OA\Parameter(
 *     name = "profile",
 *     in = "path",
 *     description = "user profile",
 *     required = true
 *   ),
 *   @OA\Parameter(
 *     name = "userid",
 *     in = "path",
 *     description = "user userid(optional if API role)",
 *     required = true
 *   ),
 *   @OA\Parameter(
 *     name = "condid",
 *     in = "path",
 *     description = "user condid",
 *     required = true
 *   ),
 *   @OA\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   ),
 *   security={
 *   { "ApiKey": {},"ApiClient": {},"AppId": {}},
 *   { "ApiKey": {},"ApiClient": {},"UserToken": {}}
 *   }
 * )
 */
