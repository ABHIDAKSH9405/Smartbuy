using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsAppFixIT
{
    public partial class FormBannirUtilisateur : Form
    {
        private string connectionString = @"Server=.\SQLEXPRESS;Database=Fixit;Trusted_Connection=True;";
        public FormBannirUtilisateur()
        {
            InitializeComponent();
        }

        private void FillCompte()
        {
            listBoxCompte.Items.Clear();

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();

            string sql = "select * from LOGIN order by Utilisateur";
            SqlCommand cmd = new SqlCommand(sql, cn);
            SqlDataReader drcat = cmd.ExecuteReader();
            while (drcat.Read())
            {
                string nom = drcat["Utilisateur"].ToString();
                listBoxCompte.Items.Add(nom);
            }

            drcat.Close();
            cn.Close();

            textBoxCompte.Text = "";
        }

        private void buttonFermer_Click(object sender, EventArgs e)
        {
            this.Close();   
        }

        private void textBox1_TextChanged(object sender, EventArgs e)
        {

        }

        private void FormBannirUtilisateur_Load(object sender, EventArgs e)
        {
            FillCompte();
        }

        private void listBoxCompte_SelectedIndexChanged(object sender, EventArgs e)
        {
            textBoxCompte.Text = listBoxCompte.SelectedItem.ToString();
        }

        private void buttonBannir_Click(object sender, EventArgs e)
        {
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "DELETE FROM LOGIN WHERE Utilisateur = @compte";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@compte", listBoxCompte.SelectedItem.ToString());
            cmd.ExecuteNonQuery();
            cn.Close();
            FillCompte();
        }
    }
}
