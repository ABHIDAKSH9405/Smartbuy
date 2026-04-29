// SQL à exécuter dans SSMS avant de lancer l'application :
// ALTER TABLE CATEGORIE ADD ImagePath VARCHAR(255) NULL;

using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsAppFixIT
{
    public partial class FormCategorie : Form
    {
        private string connectionString = @"Server=.\SQLEXPRESS;Database=Fixit;Trusted_Connection=True;";
        private DataTable _categories = new DataTable();

        public FormCategorie()
        {
            InitializeComponent();
        }

        private void FormCategorie_Load(object sender, EventArgs e)
        {
            FillCat();
        }

        private void FillCat()
        {
            listBoxCategorie.Items.Clear();
            _categories = new DataTable();

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();

            string sql = "SELECT ID_CAT, Nom, ImagePath FROM Categorie ORDER BY Nom";
            SqlDataAdapter da = new SqlDataAdapter(sql, cn);
            da.Fill(_categories);
            cn.Close();

            foreach (DataRow row in _categories.Rows)
            {
                listBoxCategorie.Items.Add(row["Nom"].ToString());
            }

            textBoxCategorie.Text = "";
            pictureBoxCategorie.Image = null;
        }

        private void listBoxCategorie_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (listBoxCategorie.SelectedIndex == -1) return;

            string nom = listBoxCategorie.SelectedItem.ToString();
            textBoxCategorie.Text = nom;

            DataRow[] rows = _categories.Select("Nom = '" + nom.Replace("'", "''") + "'");
            if (rows.Length > 0 && rows[0]["ImagePath"] != DBNull.Value)
            {
                string imagePath = rows[0]["ImagePath"].ToString();
                if (File.Exists(imagePath))
                {
                    pictureBoxCategorie.Image = Image.FromFile(imagePath);
                }
                else
                {
                    pictureBoxCategorie.Image = null;
                }
            }
            else
            {
                pictureBoxCategorie.Image = null;
            }
        }

        private void buttonPhoto_Click(object sender, EventArgs e)
        {
            ChooseAndSavePhoto();
        }

        private void buttonModifierPhoto_Click(object sender, EventArgs e)
        {
            ChooseAndSavePhoto();
        }

        private void buttonSupprimerPhoto_Click(object sender, EventArgs e)
        {
            if (listBoxCategorie.SelectedIndex == -1)
            {
                MessageBox.Show("Veuillez sélectionner une catégorie.");
                return;
            }

            string nom = listBoxCategorie.SelectedItem.ToString();
            DataRow[] rows = _categories.Select("Nom = '" + nom.Replace("'", "''") + "'");
            if (rows.Length == 0) return;

            if (rows[0]["ImagePath"] == DBNull.Value || rows[0]["ImagePath"].ToString() == "")
            {
                MessageBox.Show("Cette catégorie n'a pas de photo.");
                return;
            }

            int idCat = (int)rows[0]["ID_CAT"];

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "UPDATE CATEGORIE SET ImagePath = NULL WHERE ID_CAT = @id";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@id", idCat);
            cmd.ExecuteNonQuery();
            cn.Close();

            rows[0]["ImagePath"] = DBNull.Value;
            pictureBoxCategorie.Image = null;
        }

        private void ChooseAndSavePhoto()
        {
            if (listBoxCategorie.SelectedIndex == -1)
            {
                MessageBox.Show("Veuillez sélectionner une catégorie.");
                return;
            }

            string nom = listBoxCategorie.SelectedItem.ToString();
            DataRow[] rows = _categories.Select("Nom = '" + nom.Replace("'", "''") + "'");
            if (rows.Length == 0) return;

            int idCat = (int)rows[0]["ID_CAT"];

            OpenFileDialog ofd = new OpenFileDialog();
            ofd.Filter = "Images|*.jpg;*.jpeg;*.png";
            ofd.Title = "Choisir une image";

            if (ofd.ShowDialog() == DialogResult.OK)
            {
                string destFolder = @"C:\FixITImages\";
                if (!Directory.Exists(destFolder))
                    Directory.CreateDirectory(destFolder);

                string fileName = Path.GetFileName(ofd.FileName);
                string destPath = Path.Combine(destFolder, fileName);
                File.Copy(ofd.FileName, destPath, true);

                SqlConnection cn = new SqlConnection(connectionString);
                cn.Open();
                string sql = "UPDATE CATEGORIE SET ImagePath = @path WHERE ID_CAT = @id";
                SqlCommand cmd = new SqlCommand(sql, cn);
                cmd.Parameters.AddWithValue("@path", destPath);
                cmd.Parameters.AddWithValue("@id", idCat);
                cmd.ExecuteNonQuery();
                cn.Close();

                rows[0]["ImagePath"] = destPath;

                pictureBoxCategorie.Image = Image.FromFile(destPath);
            }
        }

        private void buttonAdd_Click(object sender, EventArgs e)
        {
            if (IsPresent(textBoxCategorie.Text))
            {
                MessageBox.Show("Catégorie déjà présente");
                return;
            }
            if (textBoxCategorie.Text == "")
            {
                MessageBox.Show("Catégorie vide");
                textBoxCategorie.Focus();
                return;
            }
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "INSERT INTO CATEGORIE VALUES(@thecat)";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@thecat", textBoxCategorie.Text);
            cmd.ExecuteNonQuery();
            cn.Close();
            FillCat();
        }

        private bool IsPresent(string cat)
        {
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "SELECT COUNT(*) FROM CATEGORIE WHERE Nom = @thecat";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@thecat", cat);
            int count = (int)cmd.ExecuteScalar();
            cn.Close();
            return count > 0;
        }

        private void buttonClose_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void buttonModifier_Click(object sender, EventArgs e)
        {
            if (IsPresent(textBoxCategorie.Text))
            {
                MessageBox.Show("Catégorie déjà présente");
                return;
            }
            if (textBoxCategorie.Text == "")
            {
                MessageBox.Show("Catégorie vide");
                textBoxCategorie.Focus();
                return;
            }
            if (listBoxCategorie.SelectedIndex == -1)
            {
                MessageBox.Show("Veullez sélectionner une catégorie");
                listBoxCategorie.Focus();
                return;
            }

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "UPDATE CATEGORIE SET Nom = @nouvcat WHERE Nom = @oldcat";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@nouvcat", textBoxCategorie.Text);
            cmd.Parameters.AddWithValue("@oldcat", listBoxCategorie.SelectedItem.ToString());
            cmd.ExecuteNonQuery();
            cn.Close();
            FillCat();
        }

        private void buttonSupprimer_Click(object sender, EventArgs e)
        {
            if (listBoxCategorie.SelectedIndex == -1)
            {
                MessageBox.Show("Veullez sélectionner une catégorie");
                listBoxCategorie.Focus();
                return;
            }
            if (MessageBox.Show("Voulez-vous vraiment supprimer cette catégorie ?", "Confirmation", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.No)
            {
                return;
            }

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "DELETE FROM CATEGORIE WHERE Nom = @oldcat";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@oldcat", listBoxCategorie.SelectedItem.ToString());
            cmd.ExecuteNonQuery();
            cn.Close();
            FillCat();
        }
    }
}
