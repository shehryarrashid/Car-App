<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{

    public function index(Request $request)
    {
        
        $search = $request->query('search');
        
        // Retrieve cars and paginate
        $cars = Car::when($search, function ($query) use ($search) {
            $searchTerms = explode(' ', $search);
            return $query->where(function($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function($q) use ($term) {
                        $q->where('make', 'like', '%' . $term . '%')
                          ->orWhere('model', 'like', '%' . $term . '%');
                    });
                }
            });

        })->paginate(8); // Adjust the number of items per page as needed

        return view('cars.index', [
            'cars' => $cars,
            'search' => $search,  // Pass the search term to the view
        ]);
    }

    function create()
    {
        return view('cars.create');
    }

    function about()
    {
        return view('cars.about');
    }

    function store(Request $request)
    {
        // Validate the request to ensure that all required fields are provided.
        $validatedData = $this->validateCar($request);

        // Create a new Car instance and assign validated data
        $car = new Car();
        $car->make = $validatedData['make'];
        $car->model = $validatedData['model'];
        $car->year = $validatedData['year'];
        $car->mileage = $validatedData['mileage'];
        $car->category = $validatedData['category'];

        // Save the car to the database
        $car->save();

        return redirect('/cars');
    }

    function show($id)
    {
        $car = Car::find($id);
        return view('cars.show', ['car' => $car]);
    }

    function edit($id)
    {
        $car = Car::find($id);
        return view('cars.edit', ['car' => $car]);
    }

    function update(Request $request){
        $car = Car::find($request->id);

        // Validate the request to ensure that all required fields are provided.
        $validatedData = $this->validateCar($request);

        // Create a new Car instance and assign validated data
        $car = Car::find($request->id);
        $car->make = $validatedData['make'];
        $car->model = $validatedData['model'];
        $car->year = $validatedData['year'];
        $car->mileage = $validatedData['mileage'];
        $car->category = $validatedData['category'];

        // Save the car to the database
        $car->save();

        return redirect('/cars');
    }

    function destroy(Request $request){
        $car = Car::find($request->id);
        $car->delete();
        return redirect('/cars');
    }

    function validateCar(Request $request){
        return $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1885|max:' . date("Y"),
            'mileage' => 'required|integer|min:0',
            'category' => 'required',
        ], [
            'make.required' => 'The make of the car is required.',
            'make.string' => 'The make must be a valid string.',
            'make.max' => 'The make cannot exceed 255 characters.',
        
            'model.required' => 'The model of the car is required.',
            'model.string' => 'The model must be a valid string.',
            'model.max' => 'The model cannot exceed 255 characters.',
        
            'year.required' => 'The year of the car is required.',
            'year.integer' => 'The year must be a number.',
            'year.min' => 'The year must be after 1885.',
            'year.max' => 'The year cannot be later than the current year.',
        
            'mileage.required' => 'The mileage is required.',
            'mileage.integer' => 'The mileage must be a number.',
            'mileage.min' => 'The mileage must be a positive value.',
        
        ]);   
    }

}
