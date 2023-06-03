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
            "Website",
            "Database MySql",
            "FTP"
        );

        // data e ora corrente
        $dateTime = new DateTime();

        foreach ($categories as $category) {
            // nuova istanza Category
            $newCategory = new Category();

            // setto i valori
            $newCategory->category_name = $category;
            $newCategory->created_at = $dateTime->modify("+ 1 seconds");
            $newCategory->updated_at = $newCategory->created_at;

            // save
            $newCategory->save();
        }
    }
}
