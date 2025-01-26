@props([
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'name' => '',
    'iconLeft' => null,
    'iconRight' => null,
    'value' => null,
    'id' => '-1',
    'id_label' => '-1',
])

<div class="input">
  <label for="{{$name}}" class="form-label ">
    {{$label}} <span style="color: red">{{$required ? "*" : ""}}</span>
  </label>
  <label for="{{$name}}" class="form-label " id="{{$id_label}}" style="display: none;">
   
  </label>
  <div class="input-group">
    @if($iconLeft)
      <span class="input-group-text">
        <i class="{{$iconLeft}}"></i>
      </span>
    @endif
    <input  {{ $required ? 'required' : '' }} name="{{$name}}" type="{{$type}}" class="form-control" id="{{$name}}" placeholder="{{$placeholder}}"  value="{{$value ?? ''}}" id="{{$id}}" >
 
    <!-- Slot para ícono -->
    @if($type === 'password')
      <button class="btn btn-outline-secondary toggle-password" type="button">
        <i class="far fa-eye"></i>
      </button>
    @elseif($iconRight)
      <span class="input-group-text">
        <i class="{{$iconRight}}"></i>
      </span>
    @endif
  
  </div>
</div>

<style>
  .input {
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  label {
    position: relative;
    top: 5px;
    font-size: 12px;
    font-family: 'Lato', sans-serif;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
      button.addEventListener('click', function () {
        const passwordInput = this.previousElementSibling; // Encuentra el input relacionado
        const toggleIcon = this.querySelector('i');
        
        // Alternar el tipo de entrada
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Alternar el icono
        if (type === 'password') {
          toggleIcon.classList.remove('fa-eye-slash');
          toggleIcon.classList.add('fa-eye');
        } else {
          toggleIcon.classList.remove('fa-eye');
          toggleIcon.classList.add('fa-eye-slash');
        }
      });
    });
  });
</script>
