<?php
/**
 * @OA\Get(
 *   path = "/api/v2/sample/get/condid/{condid}/profile/{profile}/userid/{userid}",
 *   tags={"Sample"},
 *   summary = "Get One register in Sample Entity, identified by id.equals",
 *   description = "Get One register in Sample Entity, identified by id.equals",
 *   @OA\Response(
 *     response = 200,
 *     description = "A object Sample with attributes",
 *     content={
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                     @OA\Property(
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
 *                         description="Name of space(limit 100 char)"
 *                     ),
 *                       @OA\Property(
 *                         property="createdAt",
 *                         type="time",
 *                         description="time creation"
 *                     ),
 *                       @OA\Property(
 *                         property="cupdatedAt",
 *                         type="time",
 *                         description="time update"
 *                     ),
 *                     example={
    "SpaceBokking": {
        "id": "3",
        "condid": "01234",
        "name": "Sample 001",
        "createdAt": "2019-01-01 00:00:00",
        "updatedAt": "2019-01-02 00:00:00"
    }
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
 *
 *   @OA\Parameter(
 *     name = "id.equals",
 *     in = "query",
 *     description = "SpaceBooking Id",
 *     required = false,
 *
 *   @OA\Schema(
 *       type = "integer",
 *     ),
 *     style = "form"
 *   ),
 *
 *   security={
 *     { "ApiKey": {},"ApiClient": {},"AppId": {}},
 *     { "ApiKey": {},"ApiClient": {},"UserToken": {}}
 *   }
 * )
 */
