<!-- resources/views/components/avatar.blade.php -->
<div class="d-flex align-items-center container-avatar sombra">
    <div class="avatar">
        <img src="{{ asset('storage/' . user()->avatar) }}" alt="" class="circle_avatar">
    </div>
    <div class="ml-3">
        <h5 class="mb-0">{{ user()->name }}</h5>
        <p class="mb-0">{{ user()->email }}</p>
        <p class="mb-0">{{ $user->roles->first()->name }}</p>
    </div>
</div>

<style>
    .container-avatar{
        background-color: #fff;
        border-radius: 50px;
        padding: 10px;
        width: 300px;
    }
    .avatar img {
        border: 2px solid #ddd;
        padding: 2px;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .ml-3 {
        margin-left: 1rem;
    }
</style>
