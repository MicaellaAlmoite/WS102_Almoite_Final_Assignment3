<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - MICA ALMOITE</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }

        .upload-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .upload-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        .upload-card h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
            font-size: 14px;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        input[type="file"]:hover {
            border-color: #3498db;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2980b9;
        }

        .gallery {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        .gallery h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .photo-item {
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .photo-item:hover {
            transform: translateY(-5px);
        }

        .photo-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .photo-info {
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .delete-btn {
            background: #e74c3c;
            padding: 5px 10px;
            font-size: 12px;
        }

        .delete-btn:hover {
            background: #c0392b;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .upload-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📸 Photo Gallery</h1>
            <div class="subtitle">MICA ALMOITE</div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="upload-section">
            <!-- Single Upload -->
            <div class="upload-card">
                <h2>📷 Upload Single Image</h2>
                <form action="{{ route('photos.storeSingle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Choose Image</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit">Upload Image</button>
                </form>
            </div>

            <!-- Multiple Upload -->
            <div class="upload-card">
                <h2>🎨 Upload Multiple Images</h2>
                <form action="{{ route('photos.storeMultiple') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Choose Images (multiple allowed)</label>
                        <input type="file" name="images[]" accept="image/*" multiple required>
                    </div>
                    <button type="submit">Upload Images</button>
                </form>
            </div>
        </div>

        <!-- Gallery -->
        <div class="gallery">
            <h2>🖼️ Image Gallery ({{ $photos->count() }} photos)</h2>
            @if($photos->count() > 0)
                <div class="photos-grid">
                    @foreach($photos as $photo)
                        <div class="photo-item">
                            <img src="{{ asset('images/' . $photo->image) }}" alt="Photo">
                            <div class="photo-info">
                                <small style="color: #7f8c8d;">{{ $photo->created_at->format('M d, Y') }}</small>
                                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Delete this image?')">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #7f8c8d; padding: 40px;">No photos yet. Upload your first image!</p>
            @endif
        </div>
    </div>
</body>
</html>