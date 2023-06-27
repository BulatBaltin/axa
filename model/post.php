<?

class Post extends dmModel {

    static function user($id) {
        return self::belongsTo( $id, 'users');
    }

    function Structure()
    {
        $structure = [
            0 => Field::id(),
            1 => Field::string('slug'),
            2 => Field::string('title'),
            3 => Field::text('description'),
            4 => Field::string('image_path'),
            5 => Field::Reference('user'),

            // 100 => Field::Int('sort'),
            102 => Field::DateTime('created_at'),
            103 => Field::DateTime('updated_at')
        ];
        return $structure;
        
    }
    function Edit() {
        Field::Edit('title','Заголовок',['func' => 'TitleEdit']);
    }
}