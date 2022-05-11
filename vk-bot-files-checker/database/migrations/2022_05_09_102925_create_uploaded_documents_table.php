<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploaded_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_path')->unique();
            $table->double('highest_similarity');
            $table->unsignedBigInteger('uploader_id');
            $table->unsignedBigInteger('most_similar_document_id');
            $table->timestamps();
            $table->foreign('uploader_id')->references('id')->on('users');
            $table->foreign('most_similar_document_id')->references('id')->on('uploaded_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploaded_documents');
    }
}
