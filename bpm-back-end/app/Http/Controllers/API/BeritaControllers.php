<?php

namespace App\Http\Controllers\API;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

/**
 * @OA\Schema(
 *     schema="Berita",
 *     type="object",
 *     required={"id", "title", "content"},
 *     @OA\Property(property="id", type="integer", description="ID Berita"),
 *     @OA\Property(property="title", type="string", description="Judul Berita"),
 *     @OA\Property(property="content", type="string", description="Isi Berita"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Tanggal dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Tanggal diperbarui")
 * )
 */
class BeritaControllers extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/berita",
     *     tags={"Berita"},
     *     summary="Ambil semua data berita",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar berita",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Berita")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $berita = Berita::all();

            return response()->json([
                'message' => 'Berita fetched successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Ambil berita berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail berita",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Berita not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            return response()->json([
                'message' => 'Berita fetched successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Berita not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/berita",
     *     tags={"Berita"},
     *     summary="Buat berita baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berita created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $berita = Berita::create($validated);

            return response()->json([
                'message' => 'Berita created successfully',
                'data' => $berita,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Update berita",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $berita = Berita::findOrFail($id);
            $berita->update($validated);

            return response()->json([
                'message' => 'Berita updated successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Hapus berita",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $berita->delete();

            return response()->json([
                'message' => 'Berita deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}


namespace App\Http\Controllers\API;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

/**
 * @OA\Schema(
 *     schema="Berita",
 *     type="object",
 *     required={"id", "title", "content"},
 *     @OA\Property(property="id", type="integer", description="ID Berita"),
 *     @OA\Property(property="title", type="string", description="Judul Berita"),
 *     @OA\Property(property="content", type="string", description="Isi Berita"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Tanggal dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Tanggal diperbarui")
 * )
 */
class BeritaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/berita",
     *     tags={"Berita"},
     *     summary="Ambil semua data berita",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar berita",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Berita")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $berita = Berita::all();

            return response()->json([
                'message' => 'Berita fetched successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Ambil berita berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail berita",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Berita not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            return response()->json([
                'message' => 'Berita fetched successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Berita not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/berita",
     *     tags={"Berita"},
     *     summary="Buat berita baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berita created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $berita = Berita::create($validated);

            return response()->json([
                'message' => 'Berita created successfully',
                'data' => $berita,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Update berita",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Berita")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $berita = Berita::findOrFail($id);
            $berita->update($validated);

            return response()->json([
                'message' => 'Berita updated successfully',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/berita/{id}",
     *     tags={"Berita"},
     *     summary="Hapus berita",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID berita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $berita->delete();

            return response()->json([
                'message' => 'Berita deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
