<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\User;
use App\Models\Seller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
use Storage;

//class SellersImport implements ToModel, WithHeadingRow, WithValidation
class SellersImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;

    public function collection(Collection $rows)
    {
        $user = Auth::user();
        
        foreach ($rows as $row) {
            $user = User::create([
                'userType' => 'seller',
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'city' => $row['city_id'],
                'district' => $row['district_id'],
            ]);
            $seller = Seller::create([
                'user_id'=> $user->id,
            ]);
            Shop::create([
                'user_id'=> $user->id,
                'name' => $row['name'],
                'logo' => $this->downloadThumbnail($row['logo']),
                'phone' => $row['phone'],
                'address' => $row['address'],
                'city_id' => $row['city_id'],
                'district_id' => $row['district_id'],
                'facebook' => $row['facebook'],
                'instagram' => $row['instagram'],
                'google' => $row['google'],
                'twitter' => $row['twitter'],
                'youtube' => $row['youtube'],
                'slug' => $row['name'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description']
            ]);
        }

        flash(translate('Sellers imported successfully'))->success();
        
    }

    public function model(array $row)
    {
        ++$this->rows;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [];
    }

    public function downloadThumbnail($url)
    {
        try {
            $upload = new Upload;
            $upload->external_link = $url;
            $upload->type = 'image';
            $upload->save();

            return $upload->id;
        } catch (\Exception $e) {
        }
        return null;
    }

    public function downloadGalleryImages($urls)
    {
        $data = array();
        foreach (explode(',', str_replace(' ', '', $urls)) as $url) {
            $data[] = $this->downloadThumbnail($url);
        }
        return implode(',', $data);
    }
}
