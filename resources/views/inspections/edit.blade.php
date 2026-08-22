@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Kemaskini Projek Pemeriksaan</h2>
        <p class="text-gray-500 text-sm mt-1">Ubah butiran atau muat naik semula imej jika perlu.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('inspection.update', $inspection->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tajuk Projek -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tajuk Projek / Nama Hartanah</label>
                    <input type="text" name="title" value="{{ old('title', $inspection->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                </div>

                <!-- Nama Klien -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Klien / Pemilik</label>
                    <input type="text" name="clientname" value="{{ old('clientname', $inspection->clientname) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                </div>

                <!-- Jenis Rumah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Hartanah</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none bg-white" required>
                        <option value="Teres Setingkat" {{ $inspection->type == 'Teres Setingkat' ? 'selected' : '' }}>Teres Setingkat</option>
                        <option value="Teres 2 Tingkat" {{ $inspection->type == 'Teres 2 Tingkat' ? 'selected' : '' }}>Teres 2 Tingkat</option>
                        <option value="Semi-D" {{ $inspection->type == 'Semi-D' ? 'selected' : '' }}>Semi-D</option>
                        <option value="Banglo" {{ $inspection->type == 'Banglo' ? 'selected' : '' }}>Banglo</option>
                        <option value="Kondominium / Apartment" {{ $inspection->type == 'Kondominium / Apartment' ? 'selected' : '' }}>Kondominium / Apartment</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Penuh</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" required>{{ old('address', $inspection->address) }}</textarea>
                </div>

                <!-- Negeri -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Negeri</label>
                    <select name="state" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none bg-white" required>
                        <option value="Selangor" {{ $inspection->state == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Kuala Lumpur" {{ $inspection->state == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Johor" {{ $inspection->state == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Pulau Pinang" {{ $inspection->state == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                        <option value="Pahang" {{ $inspection->state == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                    </select>
                </div>

                <!-- GAMBAR RUMAH -->
                <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Rumah (Muka Depan)</label>
                    @if($inspection->img)
                        <div class="mb-3">
                            <p class="text-xs text-gray-400 mb-1">Gambar Semasa:</p>
                            <img src="{{ asset('storage/' . $inspection->img) }}" class="w-32 h-24 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" id="imageInput" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                    <input type="hidden" name="cropped_image" id="croppedImageOutput">

                    <div id="cropperContainer" class="mt-4 hidden bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                        <div class="max-w-md mb-4 overflow-hidden">
                            <img id="imagePreview" src="" alt="Preview" class="max-h-72 block">
                        </div>
                        <button type="button" id="cropButton" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700">Confirm Crop Gambar Rumah</button>
                        <span id="cropStatus" class="ml-3 text-sm text-emerald-600 font-medium hidden">✓ Berjaya dipotong!</span>
                    </div>
                </div>

                <!-- PELAN LAYOUT -->
                <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pelan Layout (Menegak)</label>
                    @if($inspection->layout_img)
                        <div class="mb-3">
                            <p class="text-xs text-gray-400 mb-1">Pelan Semasa:</p>
                            <img src="{{ asset('storage/' . $inspection->layout_img) }}" class="w-24 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" id="layoutInput" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700">
                    <input type="hidden" name="cropped_layout" id="croppedLayoutOutput">

                    <div id="layoutCropperContainer" class="mt-4 hidden bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                        <div class="max-w-xs mb-4 overflow-hidden">
                            <img id="layoutPreview" src="" alt="Layout Preview" class="max-h-96 block">
                        </div>
                        <button type="button" id="cropLayoutButton" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700">Confirm Crop Layout</button>
                        <span id="layoutCropStatus" class="ml-3 text-sm text-purple-600 font-medium hidden">✓ Layout berjaya dipotong!</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('inspection.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">Simpan Kemaskini</button>
            </div>
        </form>
    </div>
</div>

<!-- Cropper.js Script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const cropperContainer = document.getElementById('cropperContainer');
        const cropButton = document.getElementById('cropButton');
        const croppedImageOutput = document.getElementById('croppedImageOutput');
        const cropStatus = document.getElementById('cropStatus');

        if(imageInput) {
            imageInput.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        cropperContainer.classList.remove('hidden');
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(imagePreview, { aspectRatio: 4 / 3, viewMode: 1 });
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        }
        if(cropButton) {
            cropButton.addEventListener('click', function () {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
                    croppedImageOutput.value = canvas.toDataURL('image/jpeg', 0.8);
                    cropStatus.classList.remove('hidden');
                }
            });
        }

        let layoutCropper;
        const layoutInput = document.getElementById('layoutInput');
        const layoutPreview = document.getElementById('layoutPreview');
        const layoutCropperContainer = document.getElementById('layoutCropperContainer');
        const cropLayoutButton = document.getElementById('cropLayoutButton');
        const croppedLayoutOutput = document.getElementById('croppedLayoutOutput');
        const layoutCropStatus = document.getElementById('layoutCropStatus');

        if(layoutInput) {
            layoutInput.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        layoutPreview.src = e.target.result;
                        layoutCropperContainer.classList.remove('hidden');
                        if (layoutCropper) layoutCropper.destroy();
                        layoutCropper = new Cropper(layoutPreview, { aspectRatio: 3 / 4, viewMode: 1 });
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        }
        if(cropLayoutButton) {
            cropLayoutButton.addEventListener('click', function () {
                if (layoutCropper) {
                    const canvas = layoutCropper.getCroppedCanvas({ width: 600, height: 800 });
                    croppedLayoutOutput.value = canvas.toDataURL('image/jpeg', 0.8);
                    layoutCropStatus.classList.remove('hidden');
                }
            });
        }
    });
</script>
@endsection