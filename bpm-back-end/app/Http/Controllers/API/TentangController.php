<?php

namespace App\Http\Controllers\API;

use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Tentang",
 *     type="object",
 *     @OA\Property(property="ten_id", type="integer", description="ID Tentang"),
 *     @OA\Property(property="ten_category", type="string", description="Kategori Tentang"),
 *     @OA\Property(property="ten_isi", type="string", description="Isi Tentang"),
 *     @OA\Property(property="ten_status", type="integer", description="Status Tentang"),
 *     @OA\Property(property="ten_modif_by", type="string", description="Diubah oleh"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Waktu pembuatan"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Waktu pembaruan")
 * )
 */
class TentangController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/tentang/getDataTentang",
     *     summary="Get all Tentang data",
     *     operationId="getDataTentang",
     *     tags={"Tentang"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tentang"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function getDataTentang()
    {
        try {
            $data = Tentang::all();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/tentang/getDataTentangById",
     *     summary="Get Tentang data by ID",
     *     operationId="getDataTentangById",
     *     tags={"Tentang"},
     *     @OA\Parameter(
     *         name="ten_id",
     *         in="query",
     *         description="Tentang ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Tentang")
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="Data Not Found")
     * )
     */
    public function getDataTentangById(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'ten_id' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 400);
        }

        $data = Tentang::find($request->ten_id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tentang/editTentang",
     *     summary="Edit Tentang data",
     *     operationId="editTentang",
     *     tags={"Tentang"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ten_id", "ten_category", "ten_isi", "ten_status", "ten_modif_by"},
     *             @OA\Property(property="ten_id", type="integer"),
     *             @OA\Property(property="ten_category", type="string"),
     *             @OA\Property(property="ten_isi", type="string"),
     *             @OA\Property(property="ten_status", type="integer"),
     *             @OA\Property(property="ten_modif_by", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diperbarui",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="Data Not Found")
     * )
     */
    public function editTentang(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'ten_id' => 'required|integer',
            'ten_category' => 'required|string',
            'ten_isi' => 'required|string',
            'ten_status' => 'required|integer',
            'ten_modif_by' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 400);
        }

        $tentang = Tentang::find($request->ten_id);
        if (!$tentang) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $tentang->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tentang/uploadFile",
     *     summary="Upload file for Tentang",
     *     operationId="uploadFile",
     *     tags={"Tentang"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(mediaType="multipart/form-data", @OA\Schema(
     *             type="object",
     *             @OA\Property(property="file", type="string", format="binary")
     *         ))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File uploaded successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="file_name", type="string"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function uploadFile(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return response()->json(['message' => 'Tidak ada file yang diunggah atau file tidak valid'], 400);
        }

        try {
            $file = $request->file('file');
            $fileName = 'FILE_' . uniqid() . '_' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/Tentang', $fileName);

            return response()->json(['file_name' => $fileName], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengunggah file', 'error' => $e->getMessage()], 400);
        }
    }
}
