<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function issue(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_at' => 'required|date',
        ]);

        $loan = Loan::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'due_at' => $request->due_at,
            'loaned_at' => now(),
        ]);

        return response()->json($loan, 201);
    }

    public function return(Request $request, Loan $loan)
    {
        $request->validate([
            'returned_at' => 'required|date',
            'fine_amount' => 'nullable|numeric|min:0',
        ]);

        $loan->update([
            'returned_at' => $request->returned_at,
            'fine_amount' => $request->fine_amount ?? 0,
        ]);

        return response()->json($loan, 200);
    }
}
