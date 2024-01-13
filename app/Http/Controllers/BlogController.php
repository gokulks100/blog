<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'required',
            'content' => 'required',
            'author' => 'required',
            'image' => (!isset($request->id)) ? 'required' : ""
        ]);

        // $validated = $request->validated();
        if ($validate->fails()) {
            return  response()->json(['success' => false, 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images1'), $fileName);
            }

            $save_data = [
                'name' => $request->name,
                'author' => $request->author,
                'content' => $request->content
            ];

            if (isset($fileName)) {
                $save_data += ['image' => $fileName];
            }

            Blog::updateOrCreate(
                [
                    'id' => $request->id  ?? null

                ],
                $save_data
            );

            DB::commit();
            $message  = (isset($request->id)) ? "Blog Updated" : "Blog Added";
            return response()->json(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            Log::debug($e);
            return  response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = Blog::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return  Carbon::parse($data->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('updated_at', function ($data) {
                return  Carbon::parse($data->updated_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('content', function ($data) {
                return strip_tags($data->description);
            })
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data =  Blog::where('id', $id)->first();

        $data->date = Carbon::parse($data->date)->format("Y-m-d");
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Blog::where('id', $id)->first();
        if (!isset($data)) {
            return  response()->json(['success' => false, 'message' => 'data not found!']);
        }
        $data->delete();
        return response()->json(['success' => true, 'message' => 'deleted']);
    }
}
