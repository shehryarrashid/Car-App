# Project Overview
The Car Page is designed specifically for garages and car businesses, providing an intuitive platform to manage their vehicle inventory. With basic CRUD (Create, Read, Update, Delete) functionality, users can easily add new cars, view and search for existing vehicles, update car details, or remove entries. The page is equipped with search and pagination features, making it simple to find specific cars based on make, model, or other attributes. This user-friendly interface streamlines inventory management, allowing businesses to keep their car listings organized and up to date with minimal effort.

# Table of Contents

1. [Car Search and Pagination Feature](#car-search-and-pagination-feature)
    - [Code Walkthrough](#code-walkthrough)
        * [Step 1: Separating Search Terms](#step-1-separating-search-terms)
        * [Step 2: Building the Query with `where`](#step-2-building-the-query-with-where)
        * [Step 3: Paginating Results](#step-3-paginating-results)
    - [HTML Implementation for Search and Pagination](#html-implementation-for-search-and-pagination)
        - [Search Form](#search-form)
        - [Pagination Controls](#pagination-controls)
2. [User Validation for Car Form](#user-validation-for-car-form)
3. [Category Field in the Form](#category-field-in-the-form)
4. [CSS Flexbox](#css-flexbox)
    - [Navbar Container (`.navbar`)](#navbar-container-navbar)
    - [Navigation Links (`.nav-links`)](#navigation-links-nav-links)
    - [Search Bar (`.search form`)](#search-bar-search-form)
    - [Responsive Design (`@media` Query)](#responsive-design-media-query)

---

## 1. Car Search and Pagination Feature

This code snippet is part of the search functionality for a Laravel-based application that allows users to search for cars by their make and model in the database. The code is split into three main steps:
1. **Separating Search Terms**: Breaking down the search input into separate terms.
2. **Database Querying**: Building a database query to match each term in both the `make` and `model` fields.
3. **Paginating Results**: Displaying the results in pages.

---

### Code Walkthrough

```php
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
})->paginate(8);
```

---

#### Step 1: Separating Search Terms

The `explode` function breaks the search input into individual words, which allows for a flexible search experience.

```php
$searchTerms = explode(' ', $search);
```

* **Why?** When users search for a car, they may enter a phrase like "Toyota Corolla." By separating the terms, we can independently search for "Toyota" and "Corolla" within the `make` and `model` fields.
* **How?** The `explode(' ', $search)` function splits the `$search` string by spaces, resulting in an array of terms, such as `["Toyota", "Corolla"]`. Each term can then be processed individually to improve the search accuracy.

---

#### Step 2: Building the Query with `where`

This part of the code builds a database query using Laravel’s query builder to check if each term exists in either the `make` or `model` field.

```php
$query->where(function($query) use ($searchTerms) {
    foreach ($searchTerms as $term) {
        $query->where(function($q) use ($term) {
            $q->where('make', 'like', '%' . $term . '%')
              ->orWhere('model', 'like', '%' . $term . '%');
        });
    }
});
```

* **Nested Queries**: For each term in `$searchTerms`, a nested query checks both `make` and `model` fields using `where` and `orWhere` conditions.
* **Fuzzy Matching**: The `like` operator with wildcards (`%`) allows for partial matches. For example, if `$term` is "Toyota", the condition `%Toyota%` will match any car make containing "Toyota," like "Toyota Camry" or "Toyota Corolla."
* **Multiple Terms**: Each term is evaluated independently. If a search input contains multiple terms (e.g., "Toyota Corolla"), the code will look for cars that match both terms across `make` and `model`.

---

#### Step 3: Paginating Results

After building the query, the `paginate` function limits the number of results shown on a single page.

```php
->paginate(8);
```

* **Pagination**: The `paginate(8)` method limits the query results to 8 records per page, making it easier to display and manage a large number of results.
* **Automatic Links**: Using pagination will generate URLs to navigate through pages, enabling the user to browse all results with ease.

---

### HTML Implementation for Search and Pagination

---

#### Search Form

```html
<div class="search">
    <form method="GET" action="/cars">
        <input type="text" placeholder="Search..." name="search" id="search" value="{{ request('search') }}">
        <button type="submit">Go</button>
    </form>
</div>
```

- **Persistent Search**: `value="{{ request('search') }}"` retains the search input value on page reloads, ensuring the search term is visible as users navigate between pages.

---

#### Pagination Controls

The pagination controls dynamically update to maintain the search context and add ellipsis for a cleaner display when there are many pages.

---

**Previous Button**

```html
<a href="{{ $currentPage > 1 ? url()->current() . '?page=' . ($currentPage - 1) . '&search=' . request('search') : '#' }}"
   class="pagination-button {{ $currentPage === 1 ? 'disabled' : '' }}">
   &laquo; Previous
</a>
```

- **URL with Search**: The `?page=` and `&search=` parameters allow the search term to persist as users navigate, even when moving back and forth between pages.

---

**Page Numbers with Ellipsis**

```html
@if($totalPages > 7)
    @if($currentPage > 3)
        <a href="?page=1&search={{ request('search') }}">1</a>
    @endif
    @if($currentPage > 4) <span>...</span> @endif

    @for ($page = max(1, $currentPage - 2); $page <= min($totalPages, $currentPage + 2); $page++)
        <a href="?page={{ $page }}&search={{ request('search') }}" class="{{ $page == $currentPage ? 'active' : '' }}">
            {{ $page }}
        </a>
    @endfor

    @if($currentPage < $totalPages - 3) <span>...</span> @endif
    @if($currentPage < $totalPages - 2)
        <a href="?page={{ $totalPages }}&search={{ request('search') }}">{{ $totalPages }}</a>
    @endif
@else
    @for ($page = 1; $page <= $totalPages; $page++)
        <a href="?page={{ $page }}&search={{ request('search') }}" class="{{ $page == $currentPage ? 'active' : '' }}">
            {{ $page }}
        </a>
    @endfor
@endif
```

- **Ellipsis Logic**: Displays ellipsis (`...`) to simplify the pagination display:
  - At the start if the current page is far from the first page.
  - At the end if the current page is far from the last page.

---

**Next Button**

```html
<a href="{{ $currentPage < $totalPages ? url()->current() . '?page=' . ($currentPage + 1) . '&search=' . request('search') : '#' }}"
   class="pagination-button {{ $currentPage === $totalPages ? 'disabled' : '' }}">
   Next &raquo;
</a>
```

---

## 2. User Validation for Car Form

This validation setup is used in both "Add New Car" and "Edit Car" forms, optimizing code reuse by centralizing the validation logic in a single function. Here’s how it works:

---

#### Laravel Validation Logic

```php
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
        
        'year.required' => 'The year of manufacture is required.',
        'year.integer' => 'The year must be a valid integer.',
        'year.min' => 'The year cannot be earlier than 1885.',
        'year.max' => 'The year cannot exceed the current year.',
        
        'mileage.required' => 'The mileage is required.',
        'mileage.integer' => 'Mileage must be a valid number.',
        'mileage.min' => 'Mileage cannot be negative.',


        
        'category.required' => 'The category of the car is required.',
    ]);
}
```

---

## 3. Category Field in the Form

The category field helps classify cars based on their usage or type (e.g., HPI CLEAR, CAT S, CAT B). It is a radio button selector with pre-defined values:

```html
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
```

---

## 4. CSS Flexbox

Flexbox is used to create flexible and responsive layouts. Below are several Flexbox components for a responsive design:

---

### Navbar Container (`.navbar`)

```css
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #333;
    color: white;
}
```

---

### Navigation Links (`.nav-links`)

```css
.nav-links {
    display: flex;
    gap: 1rem;
}
```

---

### Search Bar (`.search form`)

```css
.search form {
    display: flex;
    gap: 0.5rem;
}
```

---

### Responsive Design (`@media` Query)

```css
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
    }

    .nav-links {
        flex-direction: column;
    }
}
```

---
