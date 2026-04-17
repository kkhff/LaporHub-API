<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Http\Request;
    use App\Models\Report;
    use App\Http\Resources\ReportResource;


    class ReportController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $reports = Report::with(['category', 'user']);

            if ($request->has('status')) {
                $reports->where('status', $request->status);
            }

            if ($request->has('search')) {
                $reports->where('title', 'like', '%' . $request->search . '%');
            }

            return ReportResource::collection($reports->latest()->paginate(10));
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|min:5',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $image = $request->file('image');
            $path = $image->store('public/reports');
            $filename = $image->hashName();

            $report = Report::create([
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $filename,
                'status' => 'pending',

            ]);

            return (new ReportResource($report))->additional([
                'success' => true,
                'message' => 'Laporan berhasil terkirim',
            ]);
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $report = Report::with(['category', 'user'])->findOrFail($id);

            return new ReportResource($report);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            $report = Report::with(['category', 'user'])->findOrFail($id);

            if ($report->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Anda tidak berhak!'
                ], 403);
            }

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|min:5',
                'description' => 'required',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ]);

            $filename = $report->image;

            if ($request->hasFile('image')) {
                Storage::delete('public/reports/' . $report->image);

                $image = $request->file('image');
                $path = $image->store('public/reports');
                $filename = $image->hashName();
            }
            $report->update([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $filename,
            ]);

            $report->refresh();

            return (new ReportResource($report))->additional([
                'success' => true,
                'message' => 'Laporan berhasil diperbarui',
            ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $report = Report::findOrFail($id);

            if ($report->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Anda tidak berhak!'
                ], 403);
            }

            Storage::delete('public/reports/' . $report->image);

            $report->delete();

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dihapus',
            ]);
        }

        public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:pending,process,resolved',
            ]);

            $report = Report::with(['category', 'user'])->findOrFail($id);

            $report->update([
                'status' => $request->status,
            ]);

            return (new ReportResource($report))->additional([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
            ]);
        }

        public function myReports(Request $request)
        {
            $query = Report::where('user_id' ,$request->user()->id);
            if ($request->has('status')){
                $query->where('status', $request->status);
            }
            if ($request->has('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            $reports = $query->latest()->paginate(10);

            return ReportResource::collection($reports);
        }
    }
