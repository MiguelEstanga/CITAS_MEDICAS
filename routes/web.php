<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\EventosCalendarController;

use App\Http\Controllers\PacientesController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\VentaController;
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/generar-pdf', [ReporteController::class, 'generarPdf'])->name('generar_pdf');
Route::get('reporte/historia/{id}' , [ReporteController::class, 'presupuesto_reporte'])->name('reporte.presupuesto');

Route::group(['middleware' => ['auth']], function () {


  //panel
  Route::prefix('panel')->group(function () {
      Route::get('/', [PanelController::class, 'index'])->name('panel.index');
      //para el doctor
      Route::post('/precio_consulta', [PanelController::class, 'guardar_precio_citas'])->name('panel.precio_citas');
  });
  Route::prefix('estadisticas')->group(function () {
      Route::get('/', [PanelController::class, 'estadisticas'])->name('estadisticas.index');
  });
  //rutas de usuario para administrador
  Route::prefix('admin')->group(function () {
    Route::get('/usuarios/{type}', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/usuarios-edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/usuarios-update/{id}', [UserController::class, 'update'])->name('admin.user.update');
  });



  Route::prefix('citas')->group(function () {
  
    
    Route::get('/mis-citas', [CitasController::class, 'mis_citas'])->name('citas.mis_citas');
    Route::get('/control-citas/{id}' , [CitasController::class, 'control_citas'])->name('citas.control_citas');
  });

  Route::prefix('agenda')->group(function () {
    Route::get('/', [CitasController::class, 'index'])->name('agenda.index');
    Route::post('destroy/{id}', [CitasController::class, 'destroy'])->name('agenda.destroy');
 
  });
  Route::prefix('eventos')->group(function () {
    Route::get('/eventos/{usuario_id}', [EventosCalendarController::class, 'eventos'])->name('eventos.eventos');
    Route::post('/eventos-store', [EventosCalendarController::class, 'store'])->name('eventos.store');
    Route::put('/eventos/update/{id}', [EventosCalendarController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/delete/{id}', [EventosCalendarController::class, 'destroy']);
  });



  Route::prefix('solicitudes')->group(function () {
  
    
    //solicitud de respuesta
    Route::get('/responder/{id_solicitud}', [SolicitudController::class, 'responder_solicitud'])->name('doctores.responder_solicitud');
    Route::post('/solicitud/responder/{id_solicitud}', [SolicitudController::class, 'responder_solicitud_store'])->name('doctores.responder_solicitud_store');
    Route::post('/solicitud/conversacion/{id_solicitud}', [SolicitudController::class, 'conversacion_store'])->name('doctores.conversacion_store');

    //para el paciente
    Route::get('/paciente', [PacientesController::class, 'mis_solicitudes'])->name('doctores.ver_solicitud_paciente');
  });

  Route::prefix('lista_doctores')->group(function () {
    Route::get('/', [PacientesController::class, 'doctores'])->name('doctores.index');
    Route::get('/solicitud/{id_doctor}', [PacientesController::class, 'solicitud'])->name('doctores.solicitud');
    Route::post('/solicitud/{id_doctor}', [PacientesController::class, 'enviar_solicitud'])->name('doctores.enviar_solicitud');
   
  });

  Route::prefix('inventario')->group(function () {
    Route::get('/', [InventarioController::class, 'inventarios'])->name('inventario.index');
    Route::post('/', [InventarioController::class, 'store'])->name('inventario.store');
    Route::put('actulizar/{item_id}', [InventarioController::class, 'update'])->name('inventario.udate');
    Route::get('inventario/{items}', [InventarioController::class , 'item'])->name('inventario.edit');
    Route::post('borrar/{items}', [InventarioController::class , 'destroy'])->name('inventario.delete');

    Route::post('aumentar/{item_id}', [InventarioController::class, 'aumentar_cantidad'])->name('inventario.aumentar_cantidad');
  });

  Route::prefix('medicamentos')->group(function () {
    Route::get('/medicamentos', [InventarioController::class, 'index'])->name('medicamentos.index');
  });
    // historia medico
    Route::prefix('historia-medica')->group(function () {
      Route::get('/{id}', [HistoriaController::class, 'index'])->name('historia-medica.index');
      Route::get('historia-medica/{id}', [PresupuestoController::class, 'ver_historia_medica'])->name('historia-medica.ver_historia_medica');
     
    });
  //presupuesto
  Route::prefix('presupuesto')->group(function () {
    Route::post('/', [PresupuestoController::class, 'store'])->name('presupuesto.store');
    Route::post('/actulizar_cancelado', [PresupuestoController::class, 'updateCancelado'])->name('presupuesto.updateCancelado');
    Route::put('/{id}', [PresupuestoController::class, 'update'])->name('presupuesto.update');
    Route::post('/odontograma', [PresupuestoController::class, 'odontograma_store'])->name('presupuesto.odontograma_store');
    Route::get('presupuesto_pdf/{id}', [PresupuestoController::class, 'persupuesto_pdf'])->name('presupuesto.persupuesto_pdf');
    Route::post('/eliminar/{id}', [PresupuestoController::class, 'eliminar'])->name('presupuesto.eliminar');
    
  });

  Route::prefix('reportes')->group(function () {
    Route::get('/reporte_presupuesto', [ReporteController::class, 'reporte_presupuesto'])->name('reportes.reporte_presupuesto');
    Route::get('/reporte_inventario', [ReporteController::class, 'reporte_inventario'])->name('reportes.reporte_inventario');
    Route::get('/reporte_medicamentos', [ReporteController::class, 'reporte_medicamentos'])->name('reportes.reporte_medicamentos');
    Route::get('/reporte_usuario', [ReporteController::class, 'reporte_usuarios'])->name('reportes.reporte_usuario');
    Route::get('/reporte_ventas', [ReporteController::class, 'reporte_ventas'])->name('reportes.reporte_ventas');
    
  });

  Route::prefix('servicios')->group(function () {
    Route::get('/', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::post('/', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::put('actulizar', [ServiciosController::class, 'update'])->name('servicios.udate');
    Route::get('servicios/{items}', [ServiciosController::class , 'item'])->name('servicios.edit');
    Route::get('borrar/{id}', [ServiciosController::class , 'destroy'])->name('servicios.delete');
  });

  Route::prefix('usuarios')->group(function () {
    Route::get('/{type}', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('registrar/', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('actulizar/{id}', [UserController::class, 'update'])->name('usuarios.udate');
    Route::get('usuarios/{items}', [UserController::class , 'item'])->name('usuarios.edit');
    Route::get('borrar/{id}', [UserController::class, 'destroy'])->name('usuarios.delete');

  });

  Route::prefix('pacientes')->group(function () {
    Route::get('/{type}', [UserController::class, 'index'])->name('usuarios.pacientes');
  });

  Route::prefix('venta')->group(function () {
    Route::post('/', [VentaController::class, 'store'])->name('venta.store');
    Route::get('/', [VentaController::class, 'index'])->name('venta.index');
    Route::get('/eliminar/{id}', [VentaController::class, 'destroy'])->name('venta.destroy');
    Route::put('/actualizar', [VentaController::class, 'update'])->name('venta.update');
  });

 

  //api
  Route::prefix('api')->group(function () {
    Route::get('/verificacion/{email}', [UserController::class, 'verificacion'])->name('api.verificacion');
  });
});
