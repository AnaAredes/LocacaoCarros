<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class LimitDateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
         // Assume que a data da reserva vem como 'inicio_date' no request (formato YYYY-MM-DD)
         $data_inicio = $request->input('data_inicio');

         if (!$data_inicio) {
             return $response;
             //response()->json(['error' => 'Data de início da reserva não informada.'], 400);
         }
 
         $inicio = Carbon::parse($data_inicio);
         $hoje = Carbon::today();
         $maxDate = $hoje->copy()->addMonths(7); // até 7 meses no futuro
 
         if ($inicio->lessThan($hoje)) {
           // return response()->json(['error' => 'Não é possível reservar datas no passado.'], 422);
           return redirect()->route('disponiveis')->with('error', 'Não é possível reservar datas no passado');
        }
        
 
         if ($inicio->greaterThan($maxDate)) {
            //return response()->json(['error' => 'Não é possível reservar datas daqui a 7 meses.'], 422);
            return redirect()->route('disponiveis')->with('error', 'As reservas só podem ser feitas para datas dentro de um período máximo de 7 meses.');
        }        
        
        return ($response);
    }
}
