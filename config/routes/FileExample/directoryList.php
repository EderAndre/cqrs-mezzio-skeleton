<?php
/**
 * @OA\Get(
 *   path = "/api/directory/list",
 *   tags={"File Manipulation Example"},
 *   summary = "Get All registers in SpaceBooking Entity, identified by condid.equals",
 *   description = "Get All registers in SpaceBooking Entity, identified by condid.equals",
 *   @OA\Response(
 *     response = 200,
 *     description = "A object SpaceBooking with attributes"
 *   ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error"
 *     ),
  *
 *   @OA\Parameter(
 *     name = "preffix",
 *     in = "query",
 *     description = "preffix",
 *     required = true,
 *
 *     @OA\Schema(
 *       type = "string",
 *     ),
 *     style = "form"
 *   )
 * )
 */
