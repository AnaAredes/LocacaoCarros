<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar uma nova classe de Repositorio em app/Repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Repository');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filePath = $path . '/' . $name . '.php';

        if (File::exists($filePath)) {
            $this->error('O repositório já existe!');
            return;
        }

        $content = <<<PHP
        <?php
        
        namespace App\Repository;
        
        class {$name}
        {
            // Exemplo de método genérico
            public function all()
            {
                // return Model::all();
            }
        
            public function find(\$id)
            {
                // return Model::findOrFail(\$id);
            }
        
            public function create(array \$data)
            {
                // return Model::create(\$data);
            }
        
            public function update(\$id, array \$data)
            {
                // \$model = Model::findOrFail(\$id);
                // \$model->update(\$data);
                // return \$model;
            }
        
            public function delete(\$id)
            {
                // return Model::destroy(\$id);
            }
        }
        PHP;

        File::put($filePath, $content);

        $this->info("Repositório {$name} criado com sucesso!");
    }
}
