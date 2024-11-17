<x-layout title="Modify car">
    <h1 class="car-title">Editing my {{$car->make}} {{$car->model}}</h1>
    

    <div class="form-container">
  <form method="POST" action="/cars" class="car-form">
    @csrf
    @method('PATCH')
        
    <input type="hidden" name="id" value="{{$car->id}}">
    <div class="form-group">
      <label for="make" class="form-label">Make:</label>
      <input type="text" id="make" name="make" class="form-input" value="{{$car->make}}"/>
      @error('make')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

<!-- Model Input -->
    <div class="form-group">
      <label for="model" class="form-label">Model:</label>
      <input type="text" id="model" name="model" class="form-input" value="{{$car->model}}"/>
      @error('model')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>
    

<!-- Year Input -->
    <div class="form-group">
      <label for="year" class="form-label">Year:</label>
      <input type="number" id="year" name="year" class="form-input" value="{{$car->year}}"/>
      @error('year')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

<!-- Mileage Input -->
    <div class="form-group">
      <label for="mileage" class="form-label">Mileage:</label>
      <input type="number" id="mileage" name="mileage" class="form-input" value="{{$car->mileage}}"/>
      @error('mileage')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

<!-- Category Input -->
    <div class="form-group category-group">
      <p class="category-title">Category:</p>
      <label class="radio-label" for="CLEAR">
        <input type="radio" id="CLEAR" name="category" value="clear" checked="checked" class="form-radio" />
        HPI CLEAR
      </label>
      <label class="radio-label" for="N">
        <input type="radio" id="N" name="category" value="n" class="form-radio" />
        (N) - Non-structural
      </label>
      <label class="radio-label" for="S">
        <input type="radio" id="S" name="category" value="s" class="form-radio" />
        (S) - Structural
      </label>
      <label class="radio-label" for="B">
        <input type="radio" id="B" name="category" value="b" class="form-radio" />
        (B) - Breaker
      </label>
    </div>

  <!-- Submit Button -->
    <div class="form-group">
      <button type="submit" class="form-button">Modify!</button>
    </div>
</form>
</div>
</x-layout>