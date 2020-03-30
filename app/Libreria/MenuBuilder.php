<?php 
namespace App\Libreria;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use Auth;

/**
 * Clase constructora del menú de usuario
 */
class MenuBuilder
{

	protected $funcionario;

	public function __construct(Funcionario $funcionario){
		$this->funcionario = $funcionario;
	}
	
	public function getMenu(){

        $menu_list = [
            'registry' => [
                ['label' => 'result indicators', 'link' => route('ListaResultados', ['page' => 1])],
                ['label' => 'product indicators', 'link' => route('ListaProductos', ['page' => 1])],
                ['label' => 'activities', 'link' => route('ListaActividades', ['page' => 1])],
                ['label' => 'plans', 'link' => route('ListaPlanes', ['page' => 1, 'tipo' => 'anual'])]
            ]
        ];

        if ($this->funcionario->tieneRol('administrador') || $this->funcionario->tieneRol('director-seplan')) {

            if (key_exists('registry', $menu_list)) {
                
                array_unshift($menu_list['registry'],
                    ['label' => 'programs', 'link' => route('ListaProgramas', ['page' => 1])],
                    ['label' => 'projects', 'link' => route('ListaProyectos', ['page' => 1])]
                );
            }


        }

        if ($this->funcionario->tieneRol('director') || $this->funcionario->tieneRol('director-seplan') || $this->funcionario->tieneRol('director-ejecutivo')) {

            $menu_list['execution'] = [
                ['label' => 'plans', 'link' => [
                    ['label' => 'approve', 'link' => route('GestionPlanes', ['gestion' => 'apr'])],
                    ['label' => 'activate', 'link' => route('GestionPlanes', ['gestion' => 'act'])],
                    ['label' => 'close', 'link' => route('GestionPlanes', ['gestion' => 'cer'])]
                ]],
                ['label' => 'supplies requests', 'link' => [
                    ['label' => 'review', 'link' => route('GestionSolicitudes', ['gestion' => 'rev'])],
                    ['label' => 'authorize', 'link' => route('GestionSolicitudes', ['gestion' => 'aut'])],
                    ['label' => 'nullify', 'link' => route('GestionSolicitudes', ['gestion' => 'nul'])]
                ]],

            ];
        }

        if ($this->funcionario->tieneRol('digitador-adq')) {

            if (key_exists('execution', $menu_list)) {
                foreach ($menu_list as $item) {
                    if (strcmp($item['label'], 'supplies requests') == 0) {
                        array_push($item['link'],['label' => 'begin process', 'link' => route('GestionSolicitudes', ['gestion' => 'proc'])]);
                    }
                }
            }else{
                $menu_list['execution'] = [
                    [
                        'label' => 'supplies requests', 'link' => [
                            ['label' => 'begin process', 'link' => route('GestionSolicitudes', ['gestion' => 'proc'])]
                        ]
                    ]
                ];
            }

        }

        if ($this->funcionario->tieneRol('digitador') || $this->funcionario->tieneRol('digitador-adq')) {
            
            $menu_list['execution'] = [
                ['label' => 'supplies requests', 'link' => [
                        ['label' => 'new', 'link' => route('NuevaSolicitud')],
                        ['label' => 'print', 'link' => route('ImprimeSolicitud')]
                    ]
                ],
                ['label' => 'plans', 'link' => [
                        ['label' => 'new', 'link' => route('NuevoPlan')],
                        ['label' => 'print', 'link' => route('ImprimePlan')],
                        ['label' => 'report', 'link' => route('NuevoInformePlan')]
                    ]
                ],
                ['label' => 'activities', 'link' => [
                        ['label' => 'new', 'link' => route('NuevaActividad')],
                        ['label' => 'print', 'link' => route('ImprimeActividad')],
                        ['label' => 'report', 'link' => route('NuevoInformeActividad')]
                    ]
                ]
            ];
        }

        $menu_list['reports'] = [
            ['label' => 'anual report', 'link' => route('InformeAnual')],
            ['label' => 'quarters report', 'link' => route('InformeTrimestral')],
            ['label' => 'activity report', 'link' => route('InformeActividades')],
        ];


        if ($this->funcionario->tieneRol('director-seplan') || $this->funcionario->tieneRol('director-ejecutivo')) {

            array_push($menu_list['reports'], ['label' => 'consolidated reports', 'link' => [
                    ['label' => 'anual', 'link' => route('InformeConsolidado', ['tipo' => 'anual'])],
                    ['label' => 'quarters', 'link' => route('InformeConsolidado', ['tipo' => 'trim'])],
                    ['label' => 'activities', 'link' => route('InformeConsolidado', ['tipo' => 'act'])],
                ]],
            );

        }

        return $menu_list;
	}

}

