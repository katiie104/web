<?php
/**
 * Array Manager - Collection of useful array functions
 */

/**
 * Find the most frequent element in an array
 */
function findMostFrequent($array) {
    if (empty($array)) {
        return null;
    }
    
    $counted = array_count_values($array);
    arsort($counted);
    return array_key_first($counted);
}

/**
 * Split an array into chunks
 */
function chunkArray($array, $size) {
    return array_chunk($array, $size);
}

/**
 * Get random elements from an array
 */
function getRandomElements($array, $num = 1) {
    if (empty($array)) {
        return [];
    }
    
    $keys = array_rand($array, min($num, count($array)));
    if (!is_array($keys)) {
        $keys = [$keys];
    }
    
    $result = [];
    foreach ($keys as $key) {
        $result[] = $array[$key];
    }
    
    return $result;
}

/**
 * Flatten a multi-dimensional array
 */
function flattenArray($array) {
    $result = [];
    
    foreach ($array as $element) {
        if (is_array($element)) {
            $result = array_merge($result, flattenArray($element));
        } else {
            $result[] = $element;
        }
    }
    
    return $result;
}

/**
 * Find maximum and minimum values in an array
 */
function findMaxMin($array) {
    if (empty($array)) {
        return ['max' => null, 'min' => null];
    }
    
    return [
        'max' => max($array),
        'min' => min($array)
    ];
}

/**
 * Sort array in ascending order
 */
function sortArray($array) {
    sort($array);
    return $array;
}

/**
 * Sort array in descending order
 */
function sortArrayDesc($array) {
    rsort($array);
    return $array;
}

/**
 * Filter even numbers from array
 */
function filterEvenNumbers($array) {
    return array_filter($array, function($value) {
        return is_numeric($value) && $value % 2 === 0;
    });
}

/**
 * Filter odd numbers from array
 */
function filterOddNumbers($array) {
    return array_filter($array, function($value) {
        return is_numeric($value) && $value % 2 !== 0;
    });
}

/**
 * Count values in array
 */
function countValues($array) {
    return array_count_values($array);
}

/**
 * Remove duplicates from array
 */
function removeDuplicates($array) {
    return array_unique($array);
}

/**
 * Merge multiple arrays
 */
function mergeArrays(...$arrays) {
    return array_merge(...$arrays);
}

/**
 * Array intersection
 */
function arrayIntersection(...$arrays) {
    return array_intersect(...$arrays);
}

/**
 * Array difference
 */
function arrayDifference($array1, $array2) {
    return array_diff($array1, $array2);
}

/**
 * Map array values
 */
function mapArray($array, $callback) {
    return array_map($callback, $array);
}

/**
 * Reduce array
 */
function reduceArray($array, $callback, $initial = null) {
    return array_reduce($array, $callback, $initial);
}

/**
 * Search value in array
 */
function searchArray($array, $value) {
    $result = array_search($value, $array);
    return $result !== false ? $result : -1;
}

/**
 * Get array keys
 */
function getArrayKeys($array) {
    return array_keys($array);
}

/**
 * Get array values
 */
function getArrayValues($array) {
    return array_values($array);
}

/**
 * Check if array contains value
 */
function arrayContains($array, $value) {
    return in_array($value, $array);
}

/**
 * Reverse array
 */
function reverseArray($array) {
    return array_reverse($array);
}

/**
 * Calculate array sum
 */
function arraySum($array) {
    return array_sum($array);
}

/**
 * Calculate array average
 */
function arrayAverage($array) {
    if (empty($array)) {
        return 0;
    }
    return array_sum($array) / count($array);
}

// Demo usage and testing
function demoArrayFunctions() {
    echo "=== Array Manager Demo ===\n\n";
    
    $sampleArray = [1, 2, 3, 4, 5, 2, 3, 2, 1, 6, 7, 8, 2];
    $multiArray = [[1, 2], [3, [4, 5]], 6];
    
    echo "Original Array: " . implode(', ', $sampleArray) . "\n";
    echo "Multi-dimensional Array: " . json_encode($multiArray) . "\n\n";
    
    // Test all functions
    echo "1. Most Frequent: " . findMostFrequent($sampleArray) . "\n";
    
    echo "2. Chunked Array:\n";
    $chunks = chunkArray($sampleArray, 3);
    foreach ($chunks as $index => $chunk) {
        echo "   Chunk " . ($index + 1) . ": " . implode(', ', $chunk) . "\n";
    }
    
    echo "3. Random Elements: " . implode(', ', getRandomElements($sampleArray, 3)) . "\n";
    echo "4. Flattened Array: " . implode(', ', flattenArray($multiArray)) . "\n";
    
    $maxMin = findMaxMin($sampleArray);
    echo "5. Max: " . $maxMin['max'] . ", Min: " . $maxMin['min'] . "\n";
    
    echo "6. Sorted Asc: " . implode(', ', sortArray($sampleArray)) . "\n";
    echo "7. Sorted Desc: " . implode(', ', sortArrayDesc($sampleArray)) . "\n";
    echo "8. Even Numbers: " . implode(', ', filterEvenNumbers($sampleArray)) . "\n";
    echo "9. Odd Numbers: " . implode(', ', filterOddNumbers($sampleArray)) . "\n";
    
    echo "10. Value Counts:\n";
    $counts = countValues($sampleArray);
    foreach ($counts as $value => $count) {
        echo "    $value: $count times\n";
    }
    
    echo "11. Without Duplicates: " . implode(', ', removeDuplicates($sampleArray)) . "\n";
    echo "12. Array Sum: " . arraySum($sampleArray) . "\n";
    echo "13. Array Average: " . number_format(arrayAverage($sampleArray), 2) . "\n";
    echo "14. Contains '5': " . (arrayContains($sampleArray, 5) ? 'Yes' : 'No') . "\n";
    echo "15. Reversed Array: " . implode(', ', reverseArray($sampleArray)) . "\n";
}

// Run demo if this file is executed directly
if (basename($_SERVER['PHP_SELF']) === 'array_manager.php') {
    demoArrayFunctions();
}

// CSS style for HTML output (if needed)
$arrayManagerStyles = "
.array-manager {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #f5f5f5;
    border-radius: 8px;
}

.array-result {
    background: white;
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    border-left: 4px solid #007bff;
}
";
?>