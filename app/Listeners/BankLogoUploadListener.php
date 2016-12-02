<?php

namespace codeFin\Listeners;

use codeFin\Events\BankStoredEvent;
use codeFin\Models\Bank;
use codeFin\Repositories\BankRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BankLogoUploadListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  BankStoredEvent  $event
     * @return void
     */
    public function handle(BankStoredEvent $event) {
        $bank = $event->getBank();
        $logo = $event->getLogo(); // variavel do tipo uploadedFile
        if ($logo) {
            $name = $bank->created_at != $bank->updated_at ? $bank->logo : md5(time()) . '.' . $logo->guessExtension();
            $destFile = Bank::logosDir();
            $result = \Storage::disk('public')->putFileAs($destFile, $logo, $name);
            if ($result && $bank->created_at == $bank->updated_at) {
                $this->repository->update(['logo' => $name], $bank->id);
            }
        }
    }

}
