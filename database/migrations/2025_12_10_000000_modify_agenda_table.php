    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::table('agenda', function (Blueprint $table) {
                // Change tanda_tangan column from string to longText
                $table->longText('tanda_tangan')->nullable()->change();
            });
        }

        public function down(): void
        {
            Schema::table('agenda', function (Blueprint $table) {
                $table->string('tanda_tangan')->nullable()->change();
            });
        }
    };
