 <form novalidate class="reminder-form">
   @csrf
   <div class="container">
     <div class="row">
       <div class="form-group col-12 col-md-4">
         <label for="kilometer">{{ __('app.Kilometer') }} ({{ __('app.Km') }})</label>
         <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"   class="form-control" id="kilometer" min="1" aria-describedby="number of kilometers"
           placeholder="{{ __('app.Km') }}">
         <div class="invalid-feedback d-block km">
           {{ __('app.enter_a_valid_number_of_kilometer') }}.
         </div>
       </div>
       <div class="form-group col-12 col-md-4">
         <label for="days">{{ __('app.Days') }}</label>
         <input type="number" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"   class="form-control" id="days" min="1" max="365" aria-describedby="number of days"
           placeholder="(1  - 365)">
         <div class="invalid-feedback d-block day">
           {{ __('app.enter_a_valid_number_of_days') }}.
         </div>
       </div>
       <div class="col-12 col-md-4 text-center mt-4">
         <button type="submit" class="btn btn-primary submit-btn waves-effect waves-light px-4 py-2"
           style="width: 200px;">{</button>
       </div>
     </div>
   </div>



 </form>
