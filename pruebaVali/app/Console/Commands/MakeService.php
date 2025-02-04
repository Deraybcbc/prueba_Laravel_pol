<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear una nueva clase de servicio';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        // Verifica si el archivo ya existe
        if (file_exists($path)) {
            $this->components->error("El servicio [{$path}] ya existe.");
            return;
        }

        // Crea el directorio si no existe
        (new Filesystem())->ensureDirectoryExists(app_path('Services'));

        // Plantilla de la clase de servicio
        $content = <<<PHP
<?php

namespace App\Services;

class {$name}
{
    // Agrega la lógica de tu servicio aquí
}
PHP;

        // Crea el archivo
        file_put_contents($path, $content);

        // Muestra un mensaje de éxito similar al estilo de Laravel
        $this->components->info("Service [{$path}] creado correctamente.");
    }
}
