<?php

namespace App\Classes;

use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class FileOriginalityChecker
{
    private $shinlgeLength;
    private $stopSymbols = ["\n", "\r", ".", ",", "!", "?", ":", ";", "-", "+", "/", "\t"];
    private $stopWords =
        [
            " это ", " как ", " так ",
            " и ", " над ", " к ",
            " в ", " до ", " за ",
            " не ", " на ", " но ",
            " то ", " с ", " ли ",
            " а ", " во ", " от ",
            " со ", " для ", " о ",
            " же ", " ну ", " вы ",
            " бы ", " что ", " кто ",
            " он ", " она ", " из "
        ];

    public function __construct($shinlgeLength)
    {
        $this->shinlgeLength = $shinlgeLength;
    }

    public function checkOriginality($fileName): array
    {
        $percents = [];
        $currentFileHashes = $this->prepareHashes($fileName);
        $allFiles = scandir(storage_path('uploads'));
        $allFiles = array_values(array_filter($allFiles, function ($name) {
            return str_ends_with($name, '.docx') || str_ends_with($name, '.pdf');
        }));
        if (count($allFiles) < 2)
            return [
                "name" => NULL,
                "percents" => 0
            ];
        foreach ($allFiles as $file) {
            if (str_ends_with($file, '.docx') || str_ends_with($file, '.pdf')) {
                if ($file === $fileName)
                    continue;
                $directoryFileCashes = $this->prepareHashes($file);
                array_push($percents, $this->compareHashes($currentFileHashes, $directoryFileCashes));
            }
        }
        $maxFit = max($percents);
        $index = array_search($maxFit, $percents);
        return [
            "name" => $allFiles[$index],
            "percents" => $maxFit
        ];
    }

    private function readDocxFile($fileName)
    {
        $filename = storage_path('uploads/') . $fileName;
        $content = '';
        if (!$filename || !file_exists($filename))
            return false;
        $zip = zip_open($filename);
        if (!$zip || is_numeric($zip))
            return false;
        while ($zip_entry = zip_read($zip)) {
            if (!zip_entry_open($zip, $zip_entry))
                continue;
            if (zip_entry_name($zip_entry) != "word/document.xml")
                continue;
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
        }
        zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        return strip_tags($content);
    }

    private function readPdfFile($fileName): string
    {
        $filename = storage_path('uploads/') . $fileName;
        $parser = new Parser();
        return $parser->parseFile($filename)->getText();
    }

    private function readContent($fileName)
    {
        if (str_ends_with($fileName, '.docx'))
            return $this->readDocxFile($fileName);
        if (str_ends_with($fileName, '.pdf'))
            return $this->readPdfFile($fileName);
        throw new \Exception("Ошибка обработки файла");
    }

    private function canonizeText($input) : string
    {
        $input = str_replace($this->stopSymbols, ' ', $input);
        $input = str_replace($this->stopWords, ' ', $input);
        $input = trim($input);
        return  preg_replace('/^ +| +$|( ) +/m', '$1', $input);
    }

    private function calculateShingles($input) : array
    {
        $output = [];
        $words = explode(' ', $input);
        $wordsNumber = count($words);
        $shinglesCount = $wordsNumber - $this->shinlgeLength + 1;
        for ($i = 0; $i < $shinglesCount; $i++) {
            $temp = array_slice($words, $i, $this->shinlgeLength);
            $nextItem = implode(' ', $temp);
            array_push($output, $nextItem);
        }
        return $output;
    }

    private function createHashes($shingles): array
    {
        $result = [];
        foreach ($shingles as $shingle) {
            $append =
                [
                    crc32($shingle)
                ];
            array_push($result, $append);
        }
        return $result;
    }

    private function compareHashes($firstFileHash, $secondFileHash)
    {
        set_time_limit(0);
        $matchesCount = 0;
        foreach ($firstFileHash as $item) {
            if (in_array($item, $secondFileHash)) {
                $matchesCount++;
            }
        }
        return ($matchesCount * 2)/floatval(count($firstFileHash) + count($secondFileHash)) * 100;
    }

    private function prepareHashes($fileName): array
    {
        $content = $this->readContent($fileName);
        $canonizedText = $this->canonizeText($content);
        $currentFileShingles = $this->calculateShingles($canonizedText);
        return $this->createHashes($currentFileShingles);
    }
}
