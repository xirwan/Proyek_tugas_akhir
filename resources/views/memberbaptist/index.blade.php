<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Baptis</title>
</head>
<body>
    @foreach($baptists as $baptist)
    <form method="GET" action="{{ route('member-baptist.classes', encrypt($baptist->id)) }}">
        <div>
            <label>Pilih Baptis:</label>
            <select name="baptist_id">
                <option value="">Pilih Baptis</option>
                    <option value="{{ $baptist->id }}">{{ $baptist->date }}</option>
                </select>
            </div>
            
            <button type="submit">Pilih Kelas</button>
        </form>
    @endforeach

    @if($baptistClasses->isNotEmpty())
        <form method="POST" action="#">
            @csrf
            <div>
                <label>Pilih Kelas Baptis:</label>
                <select name="baptist_class_id">
                    <option value="">Pilih Kelas Baptis</option>
                    @foreach($baptistClasses as $class)
                        <option value="{{ $class->id }}">{{ $class->day }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Daftar</button>
        </form>
    @endif
</body>
</html>