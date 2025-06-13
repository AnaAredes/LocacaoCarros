<?php

namespace App\Http\Controllers;

use App\Services\Finders\BensLocaveisFinder;

class BensLocaveisController extends Controller
{
    protected $bensLocaveis;

    /**
     * Construtor da classe BensLocaveisController.
     *
     * Inicializa a instância do serviço BensLocaveisService para manipulação de bens locáveis.
    */
    public function __construct()
    {
        $this->bensLocaveis = new BensLocaveisFinder();
    }

    /**
     * Obtém um bem específico pelo ID e exibe as suas características.
     *
     * @param int $id O identificador único do bem.
     * @return \Illuminate\View\View Retorna a view 'detalhes' com arrays associativos com informações sobre o bem locável.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Se o bem não for encontrado.
    */
    public function getOne($id)
    {
        if (!$id) {
            abort(404, 'Bem não encontrado.');
        } else {
            session()->forget('bem_id');

            $bem_caracteristicas= $this->bensLocaveis->extrairCaracteristicasComBem($id, false);

            if (!$bem_caracteristicas['bem']) {
                abort(404, 'Bem não encontrado');
            }
            
            //tirar do array
            session(['bem_id' => [
                'id' => $id,
            ]]);

            return view('detalhes', [
                'bem' => $bem_caracteristicas['bem'], 
                'caracteristicas' => $bem_caracteristicas['caracteristicas']]);
        }
    }
}
