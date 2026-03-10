<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\VisitorAlert;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'flat' => 'required',
            'purpose' => 'required',
        ]);

        $requestId = bin2hex(random_bytes(8));
        $timestamp = date('h:i A');

        $visitor = VisitorRequest::create([
            'id' => $requestId,
            'name' => $request->name,
            'phone' => $request->phone,
            'flat' => $request->flat,
            'purpose' => $request->purpose,
            'timestamp' => $timestamp,
            'status' => 'waiting',
            'createdAt' => (int)(microtime(true) * 1000),
        ]);

        $host = 'http://10.100.10.162:5173';
        
        $verifyLink = $host . "/resident/" . $requestId;

        // Send email
        $recipientEmail = 'vinithkumar78878@gmail.com';
        try {
            Mail::to($recipientEmail)->send(new VisitorAlert($visitor, $verifyLink));
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error("Email failed: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Visitor registered.',
            'data' => ['requestId' => $requestId]
        ]);
    }

    public function getRequest($id)
    {
        $request = VisitorRequest::find($id);
        if (!$request) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $request]);
    }

    public function getStatus($id)
    {
        $request = VisitorRequest::find($id);
        if (!$request) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        return response()->json([
            'success' => true, 
            'status' => $request->status, 
            'reason' => $request->reason
        ]);
    }

    public function approve($id)
    {
        $request = VisitorRequest::find($id);
        if (!$request) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        $request->update(['status' => 'approved']);

        // Notify Node socket server
        try {
            Http::post("http://localhost:3001/api/internal/status-update", [
                'requestId' => $id,
                'status' => 'approved'
            ]);
        } catch (\Exception $e) {
            \Log::error("Socket notification failed: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Visitor approved.']);
    }

    public function reject(Request $request, $id)
    {
        $visitorRequest = VisitorRequest::find($id);
        if (!$visitorRequest) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        $reason = $request->reason ?: 'Not expecting anyone';
        $visitorRequest->update(['status' => 'denied', 'reason' => $reason]);

        // Notify Node socket server
        try {
            Http::post("http://localhost:3001/api/internal/status-update", [
                'requestId' => $id,
                'status' => 'denied',
                'reason' => $reason
            ]);
        } catch (\Exception $e) {
            \Log::error("Socket notification failed: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Visitor rejected.']);
    }

    public function getAll()
    {
        $visitors = VisitorRequest::orderBy('createdAt', 'desc')->get();
        return response()->json(['success' => true, 'data' => $visitors]);
    }
}
