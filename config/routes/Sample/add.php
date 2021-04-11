<?php
/**
 * @OA\Post(
 *   path = "/api/v2/sample/add/condid/{condid}/profile/{profile}/userid/{userid}",
 *   tags={"Sample"},
 *   summary = "Add register in Sample Entity ",
 *   description = "Insert a register Sample Entity ",
 *
 *   @OA\Response(
 *     response = 200,
 *     description = "On Success return confirmation message",
 *     content={
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                    @OA\Property(
 *                         property="id",
 *                         type="integer",
 *                         description="id of new space added"
 *                     ),
 *                     @OA\Property(
 *                         property="condid",
 *                         type="string",
 *                         description="condominium unique id"
 *                     ),
 *                     @OA\Property(
 *                         property="name",
 *                         type="string",
 *                         description="Name (limit 100 char)"
 *                     ),
 *                     example={
    "Status": "success"
 *                     }
 *                 )
 *             )
 *         }
 *   ),
 *     @OA\Response(
 *         response=401,
 *         description="Unautorized",
 *          content={
 *              @OA\MediaType(
 *                 mediaType="application/json",
 *                  @OA\Schema(
 *              
 *                      example="Authentication Failed"
 *                  )
 *          )
 *          }
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Prohibited",
 *          content={
 *              @OA\MediaType(
 *                 mediaType="application/json",
 *                  @OA\Schema(
 *              
 *                      example="Invalid APi Key"
 *                  )
 *          )
 *          }
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error"
 *     ),
 *   @OA\Parameter(
 *     name = "profile",
 *     in = "path",
 *     description = "User profile(role)",
 *     required = true
 *   ),
 *   @OA\Parameter(
 *     name = "userid",
 *     in = "path",
 *     description = "User unique identifier(optional if API role)",
 *     required = true
 *   ),
 *   @OA\Parameter(
 *     name = "condid",
 *     in = "path",
 *     description = "Condominium unique identifier",
 *     required = true
 *   ),
 *   @OA\Parameter(
 *     name = "name",
 *     in = "query",
 *     description = "name ",
 *     required = true,
 *
 *   @OA\Schema(
 *       type = "string",
 *     ),
 *     style = "form",
 *   ),
 *   security={
 *     { "ApiKey": {},"ApiClient": {},"AppId": {}},
 *     { "ApiKey": {},"ApiClient": {},"UserToken": {}}
 *   }
 * )
 */
