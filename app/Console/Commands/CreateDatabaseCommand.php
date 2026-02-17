<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use PDO;
use PDOException;

/**
 * Class CreateDatabaseCommand
 *
 * Comando utilitario para crear la base de datos definida en el .env
 * si esta no existe en el servidor MySQL local.
 *
 * @package App\Console\Commands
 */
class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la base de datos MySQL definida en .env si no existe';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Obtenemos la configuración directamente del archivo config/database.php
        // que a su vez lee el .env
        $database = Config::get('database.connections.mysql.database');
        $host = Config::get('database.connections.mysql.host');
        $port = Config::get('database.connections.mysql.port');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $charset = Config::get('database.connections.mysql.charset', 'utf8mb4');
        $collation = Config::get('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        if (!$database) {
            $this->error('Error: DB_DATABASE no está configurado en el .env');
            return Command::FAILURE;
        }

        try {
            // Conectamos sin seleccionar base de datos para poder ejecutar el CREATE
            $pdo = new PDO(
                "mysql:host={$host};port={$port}",
                $username,
                $password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Sentencia SQL segura
            $query = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET $charset COLLATE $collation;";
            
            $pdo->exec($query);

            $this->info("Verificación de base de datos completa: '{$database}'.");
            
            return Command::SUCCESS;

        } catch (PDOException $e) {
            $this->error("Falló la conexión o creación de la base de datos: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}