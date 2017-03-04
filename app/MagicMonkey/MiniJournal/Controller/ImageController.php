<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\MiniJournal\RepositoryBd\ImageBd;
use MagicMonkey\MiniJournal\RepositoryForm\ImageForm;
use MagicMonkey\Framework\Tool\FileManager\FileManager;

class ImageController extends AbstractController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function listAll()
    {
        $lstObjsImages = (new ImageBd())->selectAll();
        $this->render("image/vAllImages.html.twig", array("images" => $lstObjsImages));
    }

    public function insert()
    {
        $imageForm = new ImageForm();
        $imageeBd = new ImageBd();
        if (count($this->request->getPost()) == 0) {
            $this->render("image/vFormNewUpdate.html.twig", array(
                "title" => "Ajout d'une image",
                "action" => "insert",
                "imageForm" => $imageForm
            ));
        } else {
            $file = $this->request->getFilesParam("image");
            $fm = new FileManager();
            $infoImg = $file['tmp_name'] ? getimagesize($file['tmp_name']) : false;
            $this->request->addPostParam("file", array($file, $infoImg));
            if ($imageForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                $this->request->removePostParam('file');
                /* upload */
                $this->request->addPostParam("path", $fm->upload($file, DIR_IMAGE));
                $imageeBd->add($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Ajout effectué !";
                header('Location: index.php?a=listAll&o=image');
                exit();
            } else { // s'il y a au moins une erreur
                $imageForm->setImage($imageeBd->mapp($this->request->getPost()));
                $this->render("image/vFormNewUpdate.html.twig", array(
                    "imageForm" => $imageForm,
                    "title" => "Ajout d'une image",
                    "image" => $imageForm->getImage(),
                    "action" => "insert"
                ));
            }
        }
    }

    public function delete()
    {
        $imageBd = new ImageBd();
        $imageForm = new ImageForm();
        $isEmptyGetId = !isset($this->request->getGet()['id']);
        $isNotEmptyPostImage = isset($this->request->getPost()['image']);
        if (($isEmptyGetId && $isNotEmptyPostImage) || !$isEmptyGetId) {
            $id = $isEmptyGetId ? $this->request->getPost()['image'] : $this->request->getGet()['id'];
            $imageForm->setImage($imageBd->selectOne(array("id =" => (int)$id)));
            $res = $imageBd->deleteOne($id);
            if (!$res && $isNotEmptyPostImage) { //suppression par formulaire
                $imageForm->setErrors(array("errorImage" => "L'image doit être indiquée et doit existée"));
                $this->render("image/vFormSelect.html.twig", array(
                    "images" => $imageBd->selectAll(),
                    "imageForm" => $imageForm,
                    "action" => "delete"
                ));
            } else {
                if (!$res && !$isEmptyGetId) {
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'image ! Il se peut que l'image n'existe plus";
                } else {
                    $fm = new FileManager();
                    $fm->deleteFile($imageForm->getImage()->getPath(), DIR_IMAGE);
                    $_SESSION['success'] = "Suppression effectuée !";
                }
                header('Location: index.php?a=listAll&o=image');
                exit();
            }
        } else {
            $this->render("image/vFormSelect.html.twig", array(
                "images" => $imageBd->selectAll(),
                "imageForm" => $imageForm,
                "action" => "delete"
            ));
        }
    }

    public function describe()
    {
        if (isset($this->request->getGet()["id"])) { /* id présent */
            $image = (new ImageBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            if (!$image) { /* image inexistante */
                $_SESSION['error'] = "L'image demandée n'existe pas";
                header('Location: index.php?a=listAll&o=image');
                exit();
            } else { /* image existe */
                $this->render("image/vOneImage.html.twig", array("image" => $image));
            }
        } else { /* id non renseigné */
            $_SESSION['error'] = "Aucune image demandée";
            header('Location: index.php?a=listAll&o=image');
            exit();
        }
    }

    public function update()
    {
        $imageBd = new ImageBd();
        $imageForm = new ImageForm();
        if (!isset($this->request->getGet()['id'])) {
            $_SESSION['error'] = "Aucune image demandée";
            header('Location: index.php?o=image&a=listAll');
            exit();
        } else {
            $imageForm->setImage($imageBd->selectOne(array("id =" => (int)$this->request->getGet()['id']), false));
            if (count($this->request->getPost()) == 0) { // s'il n'y a pas de données postées
                if ($imageForm->getImage()) { // si l'image existe
                    $this->render("image/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'une image",
                        "image" => $imageForm->getImage(),
                        "action" => "update&o=image&id=" . $imageForm->getImage()->getId(),
                        "imageForm" => $imageForm
                    ));
                } else { // si elle n'existe pas
                    $_SESSION['error'] = "L'image demandée n'existe pas";
                    header('Location: index.php?o=image&a=listAll');
                    exit();
                }
            } else { // s'il y a des données postées
                $file = $this->request->getFilesParam("image");
                $fm = new FileManager();
                $infoImg = $file['tmp_name'] ? getimagesize($file['tmp_name']) : true;
                $this->request->addPostParam("file", array($file, $infoImg));
                if ($imageForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                    /* si post file infoImg == true*/
                    $test = $this->request->getPostParam('file', false);
                    if (!is_array($test[1])) {
                        /* pas besoin d'upload une nouvelle image */
                        /* add post param 'path' avec l'ancienne valeur soit  $image->getPath()*/
                        $this->request->addPostParam('path', $imageForm->getImage()->getPath());
                    } else { /* sinon */
                        /* et on upload */
                        $this->request->addPostParam("path", $fm->upload($file, DIR_IMAGE));
                        /* et on delete l'ancienne */
                        $fm->deleteFile($imageForm->getImage()->getPath(), DIR_IMAGE);
                    }
                    /* on supprime le file post */
                    $this->request->removePostParam('file');
                    /* modification de l'image dans la bdd */
                    $imageBd->update($this->request->getPost(), $imageForm->getImage()->getId());
                    $_SESSION['success'] = "Modification effectuée";
                    header('Location: index.php?o=image&a=describe&id=' . $imageForm->getImage()->getId());
                    exit();
                } else { // s'il y a au moins une erreur
                    $this->request->addPostParam('id', $imageForm->getImage()->getId());
                    $imageForm->setImage($imageBd->mapp($this->request->getPost()));
                    $this->render("image/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'une image",
                        "image" => $imageForm->getImage(),
                        "action" => "update&o=image&id=" . $imageForm->getImage()->getId(),
                        "imageForm" => $imageForm
                    ));
                }
            }
        }
    }
}
