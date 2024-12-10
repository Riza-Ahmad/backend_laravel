<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterTentang;

class MasterTentangController extends Controller
{
    protected $connection;

    public function __construct()
    {
        // Set the database connection string (use your own settings)
        $this->connection = env('DB_CONNECTION', 'mysql');
    }

    /**
     * Get all 'Tentang' data
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/master_tentang/data",
     *     summary="Get all Tentang data",
     *     tags={"Master Tentang"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Tentang data",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getDataTentang()
    {
        try {
            $data = DB::select('EXEC bpm_getDataTentang');
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data'], 400);
        }
    }

    /**
     * Get Tentang data by ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/master_tentang/data_by_id",
     *     summary="Get Tentang data by ID",
     *     tags={"Master Tentang"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ten_id"},
     *             @OA\Property(property="ten_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tentang data by ID",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getDataTentangById(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten_id' => 'required|integer',
            ]);

            $tenId = $validated['ten_id'];
            $data = DB::select('EXEC bpm_getDataTentangById @ten_id = ?', [$tenId]);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data berdasarkan ID'], 400);
        }
    }

    /**
     * Edit Tentang data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/master_tentang/edit",
     *     summary="Edit Tentang data",
     *     tags={"Master Tentang"},
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
     *         description="Tentang data updated successfully",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function editTentang(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten_id' => 'required|integer',
                'ten_category' => 'required|string',
                'ten_isi' => 'required|string',
                'ten_status' => 'required|integer',
                'ten_modif_by' => 'required|string',
            ]);

            $tenId = $validated['ten_id'];
            $tenCategory = $validated['ten_category'];
            $tenIsi = $validated['ten_isi'];
            $tenStatus = $validated['ten_status'];
            $tenModifBy = $validated['ten_modif_by'];

            $data = DB::select('EXEC bpm_editTentang ?, ?, ?, ?, ?, ?', [
                $tenId,
                $tenCategory,
                $tenIsi,
                $tenStatus,
                $tenModifBy,
                now(),
            ]);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data'], 400);
        }
    }

    /**
     * Upload file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/master_tentang/upload_file",
     *     summary="Upload file",
     *     tags={"Master Tentang"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"file"},
     *                 @OA\Property(property="file", type="file")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File uploaded successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="Hasil", type="string"))
     *     )
     * )
     */
    public function uploadFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'No file uploaded or the file is empty.'], 400);
        }

        try {
            $file = $request->file('file');
            $fileName = "FILE_" . uniqid() . "_" . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/Tentang', $fileName);

            return response()->json(['Hasil' => $fileName], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while uploading the file.', 'error' => $e->getMessage()], 400);
        }
    }
}
