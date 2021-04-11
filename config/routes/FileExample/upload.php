<?php
/**
 * @OA\Post(
 *   path = "/api/file/upload",
 *   tags={"File Manipulation Example"},
 *   summary = "Upload file to bucket ",
 *   description = "Upload file ",
 *
 *   @OA\Response(
 *     response = 200,
 *     description = "On Success return confirmation message"
 *   ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error"
 *     ),
 *
 *     @OA\RequestBody(
 *          content={
 *              @OA\MediaType(
 *                  mediaType="multipart/form-data",
 *                  @OA\Schema(
 *                      @OA\Property(
 *                          property="file",
 *                          type="file",
 *                          format="byte"
 *                      )
 *                  )
 *              )
 *          }
 *   )
 * )
 */
