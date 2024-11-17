<x-layout title="My car details">
<div class="car-details">
    <h1 class="car-title">{{$car->make}}</h1>

    <div class="car-info">
        <p><span class="label">Model:</span> {{$car->model}}</p>
        <p><span class="label">Year:</span> {{$car->year}}</p>
        <p><span class="label">Mileage:</span> {{$car->mileage}} mi</p>
        <p><span class="label">Category:</span> {{$car->category}}</p>
    </div>

    <div class="action-buttons">
        <a href='/cars/{{$car->id}}/edit' class="edit-button">
            <button>Edit</button>
        </a>

        <form method='POST' action='/cars' class="delete-form">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{$car->id}}">
            <button type='submit' class="delete-button">Delete</button>
        </form>
    </div>
</div>

</x-layout>