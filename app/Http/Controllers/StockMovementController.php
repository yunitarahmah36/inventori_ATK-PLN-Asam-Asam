<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with([
            'material',
            'user'
        ])->latest();


        // ==============================
        // SEARCH
        // ==============================

if ($request->filled('search')) {

    $search = $request->search;

    $query->where(function ($q) use ($search) {

        $q->where(
            'activity',
            'like',
            '%' . $search . '%'
        )

        ->orWhere(
            'description',
            'like',
            '%' . $search . '%'
        )

        ->orWhereHas(
            'material',
            function ($materialQuery) use ($search) {

                $materialQuery
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'material_number',
                        'like',
                        '%' . $search . '%'
                    );
            }
        )

        ->orWhereHas(
            'user',
            function ($userQuery) use ($search) {

                $userQuery
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );
            }
        );

    });
}


        // ==============================
        // FILTER AKTIVITAS
        // ==============================

        if ($request->filled('activity')) {

            $query->where(
                'activity',
                $request->activity
            );

        }


        // ==============================
        // FILTER TANGGAL MULAI
        // ==============================

        if ($request->filled('start_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );

        }


        // ==============================
        // FILTER TANGGAL SELESAI
        // ==============================

        if ($request->filled('end_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );

        }


        // ==============================
        // JUMLAH DATA PER HALAMAN
        // ==============================

        $perPage = $request->input(
            'per_page',
            25
        );


        if ($perPage === 'all') {

            $movements = $query->get();

        } else {

            $allowedPerPage = [
                10,
                25,
                50,
                100,
                250
            ];


            if (
                !in_array(
                    (int) $perPage,
                    $allowedPerPage
                )
            ) {

                $perPage = 25;

            }


            $movements = $query
                ->paginate((int) $perPage)
                ->withQueryString();

        }


        return view(
            'stock-movements.index',
            compact('movements')
        );
    }
}