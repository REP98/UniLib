<?php

namespace UniLibDemo;

use UniLib\Files\Log;
use UniLib\Orm\Manager;
use UniLibDemo\Models\IceCream;

class Demo {
    public static function createDB() {
        $pathinfo = pathinfo(env("DB_NAME"));

        $result = [
            'path' => $pathinfo['dirname'],
            'name' => $pathinfo['filename'],
            'ext'  => $pathinfo['extension']
        ];
        $mg = Manager::new_db($result['name'], $result['path'], $result['ext']);
        if (!empty($mg)) {
            Log::Info("Database {$pathinfo['filename']} creada con exito");
            $mg->create_table('icecream', [
                "id" => [
                    "INTEGER",
                    "NOT NULL",
                    "PRIMARY KEY",
                    "AUTOINCREMENT"
                ],
                'flavor' => [
                    "TEXT",
                    "NOT NULL",
                    "UNIQUE"
                ],
                'price' => [
                    "REAL",
                    "NOT NULL"
                ],
                'availability' => [
                    "BOOLEAN",
                    "NOT NULL"
                ]
            ]);
            Log::Info("Tabla `icecream` creada con exito");
            // Semilla
            $helados = [
                ['flavor' => 'Mango', 'price' => 2.50, 'availability' => true],
                ['flavor' => 'Piña Colada', 'price' => 3.00, 'availability' => true],
                ['flavor' => 'Coco', 'price' => 2.75, 'availability' => true],
                ['flavor' => 'Maracuyá', 'price' => 3.25, 'availability' => false],
                ['flavor' => 'Limón', 'price' => 2.25, 'availability' => true]
            ];
            $ic = IceCream::I();
            foreach($helados as $helado) {
                $ic->create($helado);
            }
            Log::Info("Helados Registrados");
        }
    }
}