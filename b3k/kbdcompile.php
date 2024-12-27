<?php
function includeFiles($filePath) {
    // Проверяем, существует ли файл
    if (!file_exists($filePath)) {
        return "File not found: " . $filePath;
    }
     
    // Читаем содержимое файла
    $content = file_get_contents($filePath);
    
    // Регулярное выражение для поиска строк вида (include "file.kbd")
    $pattern = '/^\(include\s+"(.+?)"\)/m';
    
    // Функция обратного вызова для обработки найденных строк
    $callback = function($matches) {
        $includeFilePath = trim($matches[1]);
        
        // Проверяем, существует ли файл, который мы хотим включить
        if (file_exists($includeFilePath)) {
            // Если файл существует, считываем его содержимое
            return file_get_contents($includeFilePath);
        } else {
            return "File not found: " . $includeFilePath;
        }
    };
    
    // Заменяем найденные строки на содержимое файлов
    $modifiedContent = preg_replace_callback($pattern, $callback, $content);
    
    return $modifiedContent;
}

// Пример использования
$filePath = $argv[1];
$modifiedContent = includeFiles($filePath);
file_put_contents("kanata.kbd", $modifiedContent);
