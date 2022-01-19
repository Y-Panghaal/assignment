<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-6" style="border:1px solid #ced4da;border-radius:0.5rem;">

                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                  </div>
                @endif

                <h3 style="text-align:center;">Request for free Sample Report</h3>

                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">
                            Your Name
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                               id="name" 
                               placeholder="Your name..." 
                               value="{{ old('name') }}"
                               required/>
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                               id="email" 
                               placeholder="Email..."
                               value="{{ old('email') }}"
                               required />
                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="company_name">
                            Company Name
                        </label>
                        <input type="text" 
                               name="company_name" 
                               class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" 
                               id="company_name" 
                               placeholder="Company name..."
                               value="{{ old('company_name') }}"
                               required />
                        @if($errors->has('company_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('company_name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="phone_number">
                            Phone Number
                        </label>
                        <input type="number" 
                               name="phone_number" 
                               class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" 
                               id="phone_number" 
                               placeholder="Phone number..."
                               value="{{ old('phone_number') }}"
                               required/>
                        @if($errors->has('phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone_number') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="country">
                            Country
                        </label>
                        <input type="text" 
                               name="country" 
                               class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" 
                               id="country" 
                               placeholder="Country..."
                               value="{{ old('country') }}"
                               required />
                        @if($errors->has('country'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="details">
                            Details
                        </label>
                        <textarea name="details" 
                                  class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" 
                                  id="details" 
                                  rows="10" 
                                  style="resize:none;"
                                  placeholder="Details...">{{ old('details') }}</textarea>
                        @if($errors->has('details'))
                            <div class="invalid-feedback">
                                {{ $errors->first('details') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mt-2 mb-2" style="text-align:center;resize:none;">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            console.log('TEST');
        });
    </script>
</body>
</html>