<?php

namespace Modules\CommandPalette\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommandPalette\Services\CommandPalette;

class CommandSearchController extends Controller
{
    public function __invoke(Request $request, CommandPalette $commandPalette): JsonResponse
    {
        $data = $request->validate([
            'query' => ['required', 'string'],
            'limit' => ['sometimes', 'numeric', 'min:1', 'max:100'],
            'args' => ['array', 'nullable'],
            'args.*' => [],
            'options' => ['array', 'nullable'],
            'options.*' => [],
        ]);

        $results = $commandPalette->search(
            query: $data['query'],
            limit: $data['limit'] ?? 5
        );

        return new JsonResponse($results);
    }
}
