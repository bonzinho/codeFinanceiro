<?php

namespace codeFin\Repositories;

use codeFin\Events\BankStoredEvent;
use codeFin\Models\Bank;
use codeFin\Presenters\BankPresenter;
use Illuminate\Http\UploadedFile;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankRepositoryEloquent
 * @package namespace codeFin\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository {

    public function create(array $attributes) {
        $logo = $attributes['logo'];
        $attributes['logo'] = env('BANK_LOGO_DEFAULT');
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true); //força o skippresenter
        $model = parent::create($attributes); // com o skip recebe o modelo eloquent
        $event = new BankStoredEvent($model, $logo);
        event($event);
        $this->skipPresenter = $skipPresenter; // skip presenter volta ao valor original
        return $this->parserResult($model);//parserResult verifica como é feito se tem ou não presenter
    }

    public function update(array $attributes, $id) {
        $logo = null;
        if (isset($attributes['logo']) && $attributes['logo'] instanceof UploadedFile) {
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true); //força o skippresenter
        $model = parent::update($attributes, $id);
        $event = new BankStoredEvent($model, $logo);
        event($event);
        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Bank::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(){
        return BankPresenter::class;
    }

}
