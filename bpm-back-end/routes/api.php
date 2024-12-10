use App\Http\Controllers\MasterTentangController;

Route::post('master_tentang/data', [MasterTentangController::class, 'getDataTentang']);
Route::post('master_tentang/data_by_id', [MasterTentangController::class, 'getDataTentangById']);
Route::post('master_tentang/edit', [MasterTentangController::class, 'editTentang']);
Route::post('master_tentang/upload_file', [MasterTentangController::class, 'uploadFile']);
