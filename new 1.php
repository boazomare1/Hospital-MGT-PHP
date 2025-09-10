<?php
class ProductBatch {
    public $batchNumber;
    public $quantity;
    public $expiryDate;

    public function __construct($batchNumber, $quantity, $expiryDate) {
        $this->batchNumber = $batchNumber;
        $this->quantity = $quantity;
        $this->expiryDate = $expiryDate;
    }
}

class Product {
    public $name;
    public $batches = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBatch($batchNumber, $quantity, $expiryDate) {
        $batch = new ProductBatch($batchNumber, $quantity, $expiryDate);
        $this->batches[] = $batch;
    }

    public function getTotalStock() {
        $totalStock = 0;
        foreach ($this->batches as $batch) {
            $totalStock += $batch->quantity;
        }
        return $totalStock;
    }

    public function getExpiringBatches($thresholdDate) {
        $expiringBatches = [];
        foreach ($this->batches as $batch) {
            if ($batch->expiryDate <= $thresholdDate) {
                $expiringBatches[] = $batch;
            }
        }
        return $expiringBatches;
    }
}

// Create a new product
$product = new Product("Example Product");

// Add batches to the product
$product->addBatch("BATCH001", 100, strtotime("+1 year"));
$product->addBatch("BATCH002", 150, strtotime("+6 months"));
$product->addBatch("BATCH003", 50, strtotime("+2 years"));

// Get total stock of the product
$totalStock = $product->getTotalStock();
echo "Total stock: $totalStock\n";

// Get batches expiring within the next 1 year
$thresholdDate = strtotime("+1 year");
$expiringBatches = $product->getExpiringBatches($thresholdDate);
echo "Expiring batches within the next year:\n";
foreach ($expiringBatches as $batch) {
    echo "Batch: {$batch->batchNumber}, Expiry: " . date("Y-m-d", $batch->expiryDate) . "\n";
}
?>
