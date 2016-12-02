<?php

namespace codeFin\Events;

use codeFin\Models\Bank;
use Illuminate\Http\UploadedFile;

class BankStoredEvent {

    private $bank;
    private $logo;

    /**
     * Create a new event instance.
     *
     * @param Bank $bank
     * @param UploadFile $logo
     */
    public function __construct(Bank $bank, UploadedFile $logo = null) {
        $this->bank = $bank;
        $this->logo = $logo;
    }

    function getBank() {
        return $this->bank;
    }

    function getLogo() {
        return $this->logo;
    }

}
