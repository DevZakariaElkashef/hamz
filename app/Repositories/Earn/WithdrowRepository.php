<?php


namespace App\Repositories\Earn;

use App\Models\Withdrow;
use App\Traits\ImageUploadTrait;


class WithdrowRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $withdrows = Withdrow::filter($request)->paginate($request->per_page ?? $this->limit);

        return $withdrows;
    }


    public function search($request)
    {
        return Withdrow::search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'withdrows');
        }
        return Withdrow::create($data);
    }


    public function update($request, $withdrow)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'withdrows', $withdrow->image);
        }
        $withdrow->update($data);
        return $withdrow;
    }


    public function delete($withdrow)
    {
        $withdrow->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Withdrow::whereIn('id', $ids)->delete();
        return true;
    }
}
