<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Services\BrandService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService) {
        $this->brandService = $brandService;
    }

    public function index()
    {
        try {
            $brands = $this->brandService->getAllBrands();
            return view('brand.index', compact('brands'));
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }

    public function getBrand()
    {
        try {
            $data = $this->brandService->getBrand();
            $brands = $data->brands;
            return response()->json(["view"=>view('brand.list.listBrand', compact('brands'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }

    public function changeStatusBrand(BrandRequest $request)
    {
        try {
            $data = $this->brandService->changeStatusBrand($request);
            $brands = $data->brands;
            return response()->json(["view"=>view('brand.list.listBrand', compact('brands'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }

    public function saveBrand(BrandRequest $request)
    {
        try {
            $data = $this->brandService->saveBrand($request);
            $brands = $data->brands;
            return response()->json(["view"=>view('brand.list.listBrand', compact('brands'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }

    public function updateArea(BrandRequest $request)
    {
        try {
            $data = $this->brandService->updateBrand($request);
            $brands = $data->brands;
            return response()->json(["view"=>view('brand.list.listBrand', compact('brands'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }

    public function deleteArea(BrandRequest $request)
    {
        try {
            $data = $this->brandService->deleteBrand($request);
            $brands = $data->brands;
            return response()->json(["view"=>view('brand.list.listBrand', compact('brands'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en BrandController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las marcas.');
        }
    }
}
