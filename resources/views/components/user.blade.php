<div class="content">
  <div class="_avatar">
      <img src="{{ asset('storage/' . $avatar) }}" alt="" class="">
  </div>
  <div class="info">
      <p>{{ $name }}</p>
      <p>{{ $email }}</p>
      <p>26101877</p>
  </div>
</div>

<style>
 .content {
    display: grid;
    grid-template-columns: 30% auto;
    border-radius: 5px;
    max-width: 300px;
    height: 80px;
    gap: 20px;
    background: var(--color_texto);
    box-shadow: 0 0 3px rgba(0, 0, 0, .4);
  }
  .content .avatar {
    display: flex;
    justify-content: center;
    align-items: center;
    
  }

  .info{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items:  flex-start ;
    color: white;
  }
  .info p{
    margin: 0;
    font-size: 12px
  }
  ._avatar{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
 
  }
  ._avatar img{
    
    width: 100%;
    height:80px;
  }
</style>