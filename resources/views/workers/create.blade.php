<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers Create</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<body>
    <div class="container mt-5">
        <h3>Workers</h3>
        <div class="row">
        <div class="card">
  <div class="card-body">
  <form action="{{route('workers.store')}}" method="POST">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" id="name"  name= "name" placeholder="Enter name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Employee id </label>
    <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{$string}}" readonly>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Phone Number </label>
    <input type="text" class="form-control" id="contact_details" name="contact_details" >
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Salary Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="salary_type">
    <option >Select Type</option>
      <option value="weekly">weekly</option>
      <option value="monthly">monthly</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Date </label>
    <input type="date" class="form-control" id="date" name="date" >
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Working Hours </label>
    <input type="number" class="form-control" id="hours_worked" name="hours_worked" >
  </div>
  <button class="btn btn-primary mt-2" type="submit">Save</button>
</form>
  </div>
</div>
        </div>
    </div>

    
</body>
</html>