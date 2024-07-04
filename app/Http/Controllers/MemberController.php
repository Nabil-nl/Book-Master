<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return Member::paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'membership_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $member = Member::create($request->all());

        return response()->json($member, 201);
    }

    public function show(Member $member)
    {
        return $member;
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:members,email,' . $member->id,
            'membership_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:255',
        ]);

        $member->update($request->all());

        return response()->json($member, 200);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json(['message' => 'Delete  successfully !!.'], 204);
    }
}
