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
        if (empty($this->request->getPost())) {
            $this->render("image/vFormNewUpdate.html.twig", array(
                "title" => "Ajout d'une image",
                "action" => "insert",
                "imageForm" => $imageForm
            ));
        } else {
            $fm = new FileManager();
            $this->request->addPostParam("path", $fm->upload($this->request->getFilesParam("image"), DIR_IMAGE));
            if ($imageForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                $imageeBd->add($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Ajout effectué !";
                header('Location: index.php?a=listAll&o=image');
                exit();
            } else { // s'il y a au moins une erreur
                $image = $imageeBd->mapp($this->request->getPost());
                $this->render("image/vFormNewUpdate.html.twig", array(
                    "iimageForm" => $imageForm,
                    "title" => "Ajout d'une image",
                    "image" => $image,
                    "action" => "insert"
                ));
            }
        }
    }

    public function delete()
    {
        $imageBd = new ImageBd();
        $imageForm = new ImageForm();
        $isEmptyGetId = empty($this->request->getGet()['id']);
        $isNotEmptyPostImage = !empty($this->request->getPost()['image']);
        if (($isEmptyGetId && $isNotEmptyPostImage) || !$isEmptyGetId) {
            $id = $isEmptyGetId ? $this->request->getPost()['image'] : $this->request->getGet()['id'];
            $image = $imageBd->selectOne(array("id =" => (int)$id));
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
                    $fm->deleteFile($image->getPath(), DIR_IMAGE);
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
        if (!empty($this->request->getGet()["id"])) { /* id pas vide */
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
        if (empty($this->request->getGet()['id'])) {
            $_SESSION['error'] = "Aucune image demandée";
            header('Location: index.php?o=image&a=listAll');
            exit();
        } else {
            $image = $imageBd->selectOne(array("id =" => (int)$this->request->getGet()['id']), false);
            if (empty($this->request->getPost())) { // s'il n'y a pas de données postées
                if ($image) { // si l'image existe
                    $this->render("image/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'une image",
                        "image" => $image,
                        "action" => "update&o=image&id=" . $image->getId(),
                        "imageForm" => $imageForm
                    ));
                } else { // si elle n'existe pas
                    $_SESSION['error'] = "L'image demandée n'existe pas";
                    header('Location: index.php?o=image&a=listAll');
                    exit();
                }
            } else { // s'il y a des données postées
                if ($imageForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                    /* modification de l'image dans la bdd */
                    $imageBd->update($this->request->getPost(), $image->getId());
                    $_SESSION['success'] = "Modification effectuée";
                    header('Location: index.php?o=image&a=describe&id=' . $image->getId());
                    exit();
                } else { // s'il y a au moins une erreur
                    $this->request->getPost()['id'] = null;
                    $tempImage = $imageBd->mapp($this->request->getPost());
                    $this->render("image/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'une image",
                        "image" => $tempImage,
                        "action" => "update&o=image&id=" . $image->getId(),
                        "imageForm" => $imageForm
                    ));
                }
            }
        }
    }
}
