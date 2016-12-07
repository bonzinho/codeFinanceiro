<?php

namespace codeFin\Presenters;

use codeFin\Transformers\BankAccountTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BankAccountPresenter
 *
 * @package namespace codeFin\Presenters;
 */
class BankAccountPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BankAccountTransformer();
    }
}
