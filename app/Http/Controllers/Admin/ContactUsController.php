<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactUsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactUsDataTable $DataTable)
    {

        $title = 'Contact Us';
        $page = 'admin.contact_us.list';
        $js = ['contact_us'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

   
    /**
     * Display the specified resource.
     */
    public function delete(Request $request)
    {
        try {

            $id = decrypt($request->id);
            $image = ContactMessage::findOrFail($id);
            $image->delete();


            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error deleting contact.'
            ]);

        }
    }
     public function deleteMultiple(Request $request)
    {
        try {
         
            $ids = $request->ids;
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IDs provided.'
                ]);
            }
            $images = ContactMessage::whereIn('id', $ids)->get();

            if ($images->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Contacts found.'
                ]);
            }
            
            ContactMessage::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contacts deleted successfully.'
            ]);
        } catch (QueryException $e) {
         
            return response()->json([
                'success' => false,
                'message' => 'Error deleting contacts.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
