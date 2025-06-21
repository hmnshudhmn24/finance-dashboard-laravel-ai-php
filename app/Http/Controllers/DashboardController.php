<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $expenses = ["Food" => 300, "Rent" => 800, "Subscriptions" => 150, "Misc" => 100];
        $income = 2000;
        return view('dashboard', compact('expenses', 'income'));
    }

    public function analyze(Request $request)
    {
        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a smart financial advisor.'],
                ['role' => 'user', 'content' => "Here is my monthly income and expenses: Income = 2000 USD, Expenses = Food 300, Rent 800, Subscriptions 150, Misc 100. Give me specific tips to save money."]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', $data);

        $result = $response->json();
        $tips = $result['choices'][0]['message']['content'] ?? 'Unable to fetch tips at this moment.';

        return view('dashboard', [
            'expenses' => ["Food" => 300, "Rent" => 800, "Subscriptions" => 150, "Misc" => 100],
            'income' => 2000,
            'tips' => $tips
        ]);
    }
}
