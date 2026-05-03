<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Server"
 * )
 */

class ProductController extends Controller
{
    private $products = [
        [
            "id" => 1,
            "name" => "Tumblr",
            "price" => 7000000,
            "stock" => 10
        ],
        [
            "id" => 2,
            "name" => "Sling Bag",
            "price" => 150000,
            "stock" => 25
        ]
    ];

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Menampilkan semua produk",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menampilkan semua produk"
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Menampilkan detail produk berdasarkan ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menampilkan detail produk"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return response()->json($product);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Menambahkan produk baru",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id","name","price","stock"},
     *             @OA\Property(property="id", type="integer", example=3),
     *             @OA\Property(property="name", type="string", example="Keyboard"),
     *             @OA\Property(property="price", type="number", example=250000),
     *             @OA\Property(property="stock", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil ditambahkan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "price" => "required|numeric",
            "stock" => "required|integer"
        ]);

        $newProduct = [
            "id" => $request->id,
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock
        ];

        $products = $this->products;
        $products[] = $newProduct;

        return response()->json([
            "message" => "Produk berhasil ditambahkan",
            "data" => $newProduct
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Mengubah seluruh informasi produk",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price","stock"},
     *             @OA\Property(property="name", type="string", example="Laptop Gaming"),
     *             @OA\Property(property="price", type="number", example=12000000),
     *             @OA\Property(property="stock", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil diupdate"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "stock" => "required|integer"
        ]);

        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                $this->products[$key] = [
                    "id" => $id,
                    "name" => $request->name,
                    "price" => $request->price,
                    "stock" => $request->stock
                ];

                return response()->json([
                    "message" => "Produk berhasil diupdate",
                    "data" => $this->products[$key]
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    /**
     * @OA\Patch(
     *     path="/api/products/{id}",
     *     summary="Mengubah sebagian data produk",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Mouse Gaming"),
     *             @OA\Property(property="price", type="number", example=300000),
     *             @OA\Property(property="stock", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil diupdate sebagian"
     *     )
     * )
     */
    public function patch(Request $request, $id)
    {
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {

                if ($request->has('name')) {
                    $this->products[$key]['name'] = $request->name;
                }

                if ($request->has('price')) {
                    $this->products[$key]['price'] = $request->price;
                }

                if ($request->has('stock')) {
                    $this->products[$key]['stock'] = $request->stock;
                }

                return response()->json([
                    "message" => "Produk berhasil diupdate sebagian",
                    "data" => $this->products[$key]
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Menghapus produk",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil dihapus"
     *     )
     * )
     */
    public function destroy($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                unset($this->products[$key]);

                return response()->json([
                    "message" => "Produk berhasil dihapus"
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }
}
