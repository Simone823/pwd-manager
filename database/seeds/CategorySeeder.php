<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // array categories
        $categories = array(
            "Email",
            "Social",
            "Website"
        );

        foreach ($categories as $key => $category) {
            // nuova istanza Category
            $newCategory = new Category();

            // setto i valori
            $newCategory->name = $category;

            // save
            $newCategory->save();
        }
    }
}
